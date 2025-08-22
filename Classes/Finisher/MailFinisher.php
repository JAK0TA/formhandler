<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\Finisher;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Mime\Address;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Mail\FluidEmail;
use TYPO3\CMS\Core\Mail\Mailer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\TemplatePaths;
use Typoheads\Formhandler\Definitions\Severity;
use Typoheads\Formhandler\Domain\Model\Config\Finisher\AbstractFinisherModel;
use Typoheads\Formhandler\Domain\Model\Config\Finisher\MailFinisherModel;
use Typoheads\Formhandler\Domain\Model\Config\FormModel;
use Typoheads\Formhandler\Domain\Model\Config\FormUploadFile;
use Typoheads\Formhandler\Domain\Model\Config\GeneralOptions\MailModel;
use Typoheads\Formhandler\Event\MailFinisherBeforeSendEvent;
use Typoheads\Formhandler\Utility\Utility;

class MailFinisher extends AbstractFinisher implements LoggerAwareInterface {
  use LoggerAwareTrait;

  private FluidEmail $emailObject;

  private MailFinisherModel $finisherConfig;

  private FormModel $formConfig;

  private ServerRequestInterface $request;

  public function __construct(
    private readonly EventDispatcherInterface $eventDispatcher,
    private readonly Utility $utility
  ) {}

  public function process(FormModel &$formConfig, AbstractFinisherModel &$finisherConfig, ServerRequestInterface $request): void {
    if (!$finisherConfig instanceof MailFinisherModel) {
      return;
    }

    $this->formConfig = $formConfig;
    $this->finisherConfig = $finisherConfig;
    $this->request = $request;

    // send usermail
    $this->sendMail($this->finisherConfig->userMailConfig, $this->formConfig->user, 'user');
    $this->sendMail($this->finisherConfig->adminMailConfig, $this->formConfig->admin, 'admin');
  }

  /**
   * Adds attachments to the current email object.
   * The specifield attachment names can be both direct filepaths and fieldnames for uploaded files.
   *
   * @param array<string, array{fileOrField: string, mime: null|string, renameTo: null|string}> $attachConfig
   */
  protected function addAttachments(array $attachConfig): void {
    $rootPath = Environment::getPublicPath();

    $fileList = [];
    foreach ($attachConfig as $identifier => $attachFile) {
      // check if the given file was uploaded
      $files = $this->getFileFromUploads($attachFile['fileOrField']);
      if ($files) {
        $counter = 0;
        foreach ($files as $file) {
          $fileList[] = [
            'path' => $file->temp,
            'name' => ($attachFile['renameTo']) ? $identifier.'_'.$attachFile['renameTo'].$counter++ : $identifier.'_'.$file->name,
            'mime' => $file->type,
          ];
        }
      } else { // wasnt uploaded. Fallback to static file
        $fileList[] = [
          'path' => $this->utility->sanitizePath($rootPath.'/'.$attachFile['fileOrField']),
          'name' => $identifier,
          'mime' => $attachFile['mime'],
        ];
      }
    }

    foreach ($fileList as $file) {
      if (file_exists($file['path'])) {
        $this->emailObject->attachFromPath($file['path'], $file['name'], $file['mime']);
      } else {
        $this->formConfig->debugMessage('file_not_found', ["Attached file {$file['name']} with path {$file['path']} not found"], Severity::Info);
      }
    }
  }

  /**
   * Add embeds to the current email object.
   *
   * @param array<string, array{fileOrField: string, mime: null|string, renameTo: null|string}> $embedConfig
   */
  protected function addEmbeds(array $embedConfig): void {
    $rootPath = Environment::getPublicPath();

    foreach ($embedConfig as $identifier => $embedFile) {
      $file = $embedFile['fileOrField'];
      $fileMime = $embedFile['mime'];
      $filePath = $this->utility->sanitizePath($rootPath.'/'.$file);

      if (file_exists($filePath)) {
        $this->emailObject->embedFromPath($filePath, $identifier, $fileMime);
      } else {
        $this->formConfig->debugMessage('file_not_found', ["Embed file {$file} with path {$filePath} not found"], Severity::Info);
      }
    }
  }

  /**
   * Replace all {marker} placeholders with the corresponding formvalue.
   */
  protected function fillSubjectMarkers(string $subject): string {
    preg_match_all('/{(.*?)}/mi', $subject, $marker);
    $valuesToFill = $this->getValuesForMarker($marker[1]);

    foreach ($marker[0] as $index => $markerToReplace) {
      $subject = str_replace($markerToReplace, $valuesToFill[$marker[1][$index]], $subject);
    }

    return $subject;
  }

  /**
   * Returns either the first (if both arent empty), the only non-empty parameter or an empty string.
   * Used when only one of two values (or neither) should be used.
   */
  protected function getAndTrimValueToSet(string $value1, string $value2): string {
    if (strlen($value1) > 0) {
      return trim($value1);
    }

    return trim($value2);
  }

  /**
   * Returns a valid email address of a given field.
   *
   * @return string the email adress. Will be empty if none was found
   */
  protected function getEmailAdressFromForm(string $fieldPath): string {
    $fieldPath = array_map('trim', explode('.', $fieldPath));

    $fieldValue = $this->utility->getFieldValue($fieldPath, $this->formConfig->formValues);
    if (!is_array($fieldValue) && GeneralUtility::validEmail(trim($fieldValue))) {
      return trim($fieldValue);
    }

    return '';
  }

  /**
   * @return false|FormUploadFile[]
   */
  protected function getFileFromUploads(string $fieldPath): array|false {
    $fieldPath = array_map('trim', explode('.', $fieldPath));
    foreach ($fieldPath as &$fieldPathLink) {
      $fieldPathLink = '['.$fieldPathLink.']';
    }
    $fieldPath = implode('', $fieldPath);

    if (isset($this->formConfig->formUploads->files[$fieldPath])) {
      return $this->formConfig->formUploads->files[$fieldPath];
    }

    return false;
  }

  /**
   * Create a array of Addresses given a comma seperated string of emails and names.
   *
   * @return Address[]
   */
  protected function getListOfAdresses(string $configMails, string $configNames): array {
    $addresses = [];

    $finisherConfigNamesArray = explode(',', $configNames);
    foreach (explode(',', $configMails) as $emailToAdd) {
      if (strlen(trim($emailToAdd)) < 1) {
        continue;
      }

      $emailNameToAdd = array_shift($finisherConfigNamesArray);
      $addresses[] = new Address(trim($emailToAdd), trim($emailNameToAdd ?? ''));
    }

    return $addresses;
  }

  /**
   * Get a list of recipient email adresses.
   *
   * @param string $recipientAddresses a comma seperated list of fieldnames and/or email adresses
   *
   * @return Address[]|false
   */
  protected function getRecipientEmailAdresses(string $recipientAddresses): array|false {
    $recipientAdded = false;
    $recipientAddressArray = [];

    $recipientAddresses = array_unique(explode(',', $recipientAddresses));
    foreach ($recipientAddresses as $emailOrFieldName) {
      $emailOrFieldName = trim($emailOrFieldName);

      if (GeneralUtility::validEmail($emailOrFieldName)) {
        $recipientAdded = true;
        $recipientAddressArray[] = new Address($emailOrFieldName);
      } else {
        $emailFromField = $this->getEmailAdressFromForm($emailOrFieldName);

        if (strlen($emailFromField) > 0) {
          $recipientAdded = true;
          $recipientAddressArray[] = new Address($emailFromField);
        }
      }
    }

    return ($recipientAdded) ? $recipientAddressArray : false;
  }

  /**
   * @param array<string> $marker
   *
   * @return array<string, string> ["marker" => "value", "marker2" => ""]
   */
  protected function getValuesForMarker(array $marker): array {
    $returnArray = [];
    foreach ($marker as $singleMarker) {
      $explodedMarker = explode('.', $singleMarker);
      $returnArray[$singleMarker] = '';

      $matchFound = true;
      $stackedFormValueVariable = $this->formConfig->formValues;
      foreach ($explodedMarker as $singleExplodedMarker) {
        if (!is_array($stackedFormValueVariable) || !array_key_exists($singleExplodedMarker, $stackedFormValueVariable)) {
          $matchFound = false;

          break;
        }

        $stackedFormValueVariable = $stackedFormValueVariable[$singleExplodedMarker];
      }

      if ($matchFound) {
        $returnArray[$singleMarker] = strval($stackedFormValueVariable);
      }
    }

    return $returnArray;
  }

  /**
   * @param array{toEmail: string, subject: string, senderEmail: string, senderName: string, replyToEmail: string, replyToName: string, ccEmail: string, ccName: string, bccEmail: string, bccName: string, returnPath: string, templateMailHtml: string, templateMailText: string, attachments: array<string, array{fileOrField: string, mime: null|string, renameTo: null|string}>, embedFiles: array<string, array{fileOrField: string, mime: null|string, renameTo: null|string}>} $finisherConfig
   */
  protected function sendMail(array $finisherConfig, MailModel $formConfig, string $mailType): void {
    try {
      $path = new TemplatePaths();
      $fluidRootPaths = $this->utility->getFluidFilePaths();
      $path->setTemplateRootPaths($fluidRootPaths['templateRootPaths']);
      $path->setLayoutRootPaths($fluidRootPaths['layoutRootPaths']);
      $path->setPartialRootPaths($fluidRootPaths['partialRootPaths']);
      $this->emailObject = GeneralUtility::makeInstance(FluidEmail::class, $path);

      // set mail format
      $this->emailObject->format('html');
      // Get Controller & Action from request
      $this->emailObject->setRequest($this->request);
      // Default Template
      // TODO: Add Ability to change/override this Template. Could also be a static file path
      $this->emailObject->setTemplate('Finishers/MailFinisher');
      $emailTemplateFile = $this->getAndTrimValueToSet($finisherConfig['templateMailHtml'], $this->formConfig->templateMailHtml);
      if (strlen($emailTemplateFile) < 1) {
        $this->formConfig->debugMessage('Mailfinisher: No template found', ["No subject line found for {$mailType} email"], Severity::Info);

        // no template = dont send email of this type
        return;
      }
      $this->emailObject->assign('mailForm', $emailTemplateFile);
      // differentiate user and admin mail by type.
      $this->emailObject->assign('emailType', $mailType);

      // subject
      $subject = $this->getAndTrimValueToSet($finisherConfig['subject'], $formConfig->subject);
      $subject = $this->fillSubjectMarkers($subject);
      if (strlen($subject) < 1) {
        $this->formConfig->debugMessage('Mailfinisher: No subject found', ["No subject line found for {$mailType} email"], Severity::Info);

        // no subject = dont send email of this type
        return;
      }
      $this->emailObject->subject($subject);

      // sender address
      $senderAddress = new Address($this->getAndTrimValueToSet($finisherConfig['senderEmail'], $formConfig->senderEmail), $this->getAndTrimValueToSet($finisherConfig['senderName'], $formConfig->senderName));
      if (strlen($senderAddress->getAddress()) < 1) {
        // subject and template are set, a mail should be send. Upgrade from info to error
        $this->formConfig->debugMessage('Mailfinisher: No sender adress found', ["No sender address found for {$mailType} email"], Severity::Error);

        return;
      }
      $this->emailObject->sender($senderAddress);

      // replyTo addresses
      $replyToAddresses = array_merge($this->getListOfAdresses($finisherConfig['replyToEmail'], $finisherConfig['replyToName']), $this->getListOfAdresses($formConfig->replyToEmail, $formConfig->replyToName));
      $this->emailObject->replyTo(...$replyToAddresses);

      // cc addresses
      $ccAddressess = array_merge($this->getListOfAdresses($finisherConfig['ccEmail'], $finisherConfig['ccName']), $this->getListOfAdresses($formConfig->ccEmail, $formConfig->ccName));
      $this->emailObject->cc(...$ccAddressess);

      // bcc addresses
      $bccAddresses = array_merge($this->getListOfAdresses($finisherConfig['bccEmail'], $finisherConfig['bccName']), $this->getListOfAdresses($formConfig->bccEmail, $formConfig->bccName));
      $this->emailObject->bcc(...$bccAddresses);

      // return path (Mail to recieve non-delivery messages)
      $returnPath = trim($finisherConfig['returnPath']);
      if (0 === strlen($returnPath)) {
        $returnPath = $GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromAddress'];
      }
      if (strlen(trim($returnPath)) > 0) {
        $this->emailObject->returnPath($returnPath);
      }

      // embeds
      $this->addEmbeds($finisherConfig['embedFiles']);

      // attachments
      $this->addAttachments($finisherConfig['attachments']);

      // recipients
      $toEmailAdresses = $this->getRecipientEmailAdresses($finisherConfig['toEmail'].','.$formConfig->toEmail);
      if (!$toEmailAdresses) {
        // subject, template and sender adress are set, a mail should be send. Upgrade from info to error
        $this->formConfig->debugMessage('Mailfinisher: No recipient adress found', ["No recipient address found for {$mailType} email"], Severity::Error);

        return;
      }
      $this->emailObject->to(...$toEmailAdresses);

      // variable assignment
      $this->emailObject->assignMultiple([
        ...$this->formConfig->formValues,
        'formValuePrefix' => $this->formConfig->formValuesPrefix,
      ]);

      /** @var MailFinisherBeforeSendEvent $beforeSendEvent */
      $beforeSendEvent = $this->eventDispatcher->dispatch(new MailFinisherBeforeSendEvent(
        $this->finisherConfig,
        $this->formConfig,
        $this->request,
        $this->emailObject,
        $this->formConfig->formValues,
      ));

      $mailer = GeneralUtility::makeInstance(Mailer::class);
      $mailer->send($beforeSendEvent->getEmailObject());
    } catch (\Exception $e) {
      $this->logger?->error($e->getMessage());

      $this->formConfig->debugMessage('Mailfinisher Error', [$e->getMessage()], Severity::Error);
    }
  }
}
