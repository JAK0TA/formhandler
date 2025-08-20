<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\Domain\Model\Config\Finisher;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Typoheads\Formhandler\Finisher\MailFinisher;
use Typoheads\Formhandler\Utility\Utility;

/** Documentation:Start:Finishers/MailFinisher.rst.
 *
 *.. _mailfinisher:
 *
 *============
 *MailFinisher
 *============
 *
 *Sends emails to specified addresses.
 *
 *
 *Documentation:End
 */
class MailFinisherModel extends AbstractFinisherModel {
  /** @var array{toEmail: string, subject: string, senderEmail: string, senderName: string, replyToEmail: string, replyToName: string, ccEmail: string, ccName: string, bccEmail: string, bccName: string, returnPath: string, templateMailHtml: string, templateMailText: string, attachments: array<string, array{fileOrField: string, mime: null|string, renameTo: null|string}>, embedFiles: array<string, array{fileOrField: string, mime: null|string, renameTo: null|string}>} */
  public readonly array $adminMailConfig;

  /** @var array{toEmail: string, subject: string, senderEmail: string, senderName: string, replyToEmail: string, replyToName: string, ccEmail: string, ccName: string, bccEmail: string, bccName: string, returnPath: string, templateMailHtml: string, templateMailText: string, attachments: array<string, array{fileOrField: string, mime: null|string, renameTo: null|string}>, embedFiles: array<string, array{fileOrField: string, mime: null|string, renameTo: null|string}>} */
  public readonly array $userMailConfig;

  private Utility $utility;

  /**
   * @param array<string, mixed>                                                                                                                                                                                                                                                                                                                                                                                                                                                            $settings
   * @param null|array{toEmail: string, subject: string, senderEmail: string, senderName: string, replyToEmail: string, replyToName: string, ccEmail: string, ccName: string, bccEmail: string, bccName: string, returnPath: string, templateMailHtml: string, templateMailText: string, attachments: array<string, array{fileOrField: string, mime: null|string, renameTo: null|string}>, embedFiles: array<string, array{fileOrField: string, mime: null|string, renameTo: null|string}>} $adminMailConfig
   * @param null|array{toEmail: string, subject: string, senderEmail: string, senderName: string, replyToEmail: string, replyToName: string, ccEmail: string, ccName: string, bccEmail: string, bccName: string, returnPath: string, templateMailHtml: string, templateMailText: string, attachments: array<string, array{fileOrField: string, mime: null|string, renameTo: null|string}>, embedFiles: array<string, array{fileOrField: string, mime: null|string, renameTo: null|string}>} $userMailConfig
   */
  public function __construct(
    private readonly array $settings,
    ?array $adminMailConfig = null,
    ?array $userMailConfig = null,
  ) {
    $this->utility = GeneralUtility::makeInstance(Utility::class);
    $this->returns = filter_var($settings['returns'] ?? false, FILTER_VALIDATE_BOOLEAN);
    $this->adminMailConfig = (null !== $adminMailConfig) ? $adminMailConfig : $this->parseEmailTypeSettings(isset($this->settings['admin']) && is_array($this->settings['admin']) ? $this->settings['admin'] : []);
    $this->userMailConfig = (null !== $userMailConfig) ? $userMailConfig : $this->parseEmailTypeSettings(isset($this->settings['user']) && is_array($this->settings['user']) ? $this->settings['user'] : []);
  }

  public function class(): string {
    return MailFinisher::class;
  }

  /**
   * @param array<mixed> $configToParse
   *
   * @return array{toEmail: string, subject: string, senderEmail: string, senderName: string, replyToEmail: string, replyToName: string, ccEmail: string, ccName: string, bccEmail: string, bccName: string, returnPath: string, templateMailHtml: string, templateMailText: string, attachments: array<string, array{fileOrField: string, mime: null|string, renameTo: null|string}>, embedFiles: array<string, array{fileOrField: string, mime: null|string, renameTo: null|string}>}
   */
  protected function parseEmailTypeSettings(array $configToParse): array {
    $parsedConfig = [];
    $optionsToParse = [
      // send options
      'toEmail',
      'subject',
      'senderEmail',
      'senderName',
      'replyToEmail',
      'replyToName',
      'ccEmail',
      'ccName',
      'bccEmail',
      'bccName',

      // additional send options
      'returnPath',
      'attachments',
      'embedFiles',

      // template options
      'templateMailHtml',
      'templateMailText',
    ];

    foreach ($optionsToParse as $option) {
      switch ($option) {
        case 'embedFiles':
        case 'attachments':
          $value = $this->parseFileConfig(isset($configToParse[$option]) && is_array($configToParse[$option]) ? $configToParse[$option] : []);

          break;

        default:
          // Try to get value from TypoScript config
          $value = $this->utility->getFieldValue([$option], $configToParse);
          // The default value should be a string. Nested Values need to be parsed seperately
          $value = (is_array($value)) ? '' : strval($value);

          break;
      }

      $parsedConfig[$option] = $value;
    }

    return $parsedConfig;
  }

  /**
   * @param array<mixed> $fileConfig
   *
   * @return array<string, array{fileOrField: string, mime: null|string, renameTo: null|string}>
   */
  protected function parseFileConfig(array $fileConfig): array {
    $parsedList = [];

    foreach ($fileConfig as $identifier => $fileOptions) {
      if (!is_array($fileOptions)) {
        continue;
      }

      $fileOrFieldName = $fileOptions['file'] ?? null;
      $fileMime = $fileOptions['mime'] ?? null;
      $renameTo = $fileOptions['renameTo'] ?? null;

      if ($fileOrFieldName) {
        $parsedList[$identifier] = [
          'fileOrField' => $fileOrFieldName,
          'mime' => $fileMime,
          'renameTo' => $renameTo,
        ];
      }
    }

    return $parsedList;
  }
}
