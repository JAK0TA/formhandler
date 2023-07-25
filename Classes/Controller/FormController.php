<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Http\RedirectResponse;
use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Typoheads\Formhandler\Definitions\FormhandlerExtensionConfig;
use Typoheads\Formhandler\Definitions\Severity;
use Typoheads\Formhandler\Domain\Model\Config\FormModel;
use Typoheads\Formhandler\Domain\Model\Config\FormUpload;
use Typoheads\Formhandler\Domain\Model\Config\FormUploadFile;
use Typoheads\Formhandler\Domain\Model\Config\GeneralOptions\FieldSetModel;
use Typoheads\Formhandler\Domain\Model\Config\Validator\Field\FieldModel;
use Typoheads\Formhandler\Domain\Model\Json\JsonResponseModel;
use Typoheads\Formhandler\Session\Typo3Session;
use Typoheads\Formhandler\Utility\Utility;

/** Documentation:Start:Index.rst.
 *
 *===============================
 *Getting Started with Formhander
 *===============================
 *
 *:Package name:
 *    jakota/formhandler
 *
 *:Version:
 *    |release|
 *
 *:Language:
 *    en
 *
 *:Author:
 *    `www.typoheads.at <https://www.typoheads.at>`__, `www.jakota.de <https://www.jakota.de>`__ & Formhander
 *    contributors see fork history on `github <https://github.com/jAK0TA/formhandler/>`__
 *
 *:Rendered:
 *    |today|
 *
 *----
 *
 *IS FORMHANDLER RIGHT FOR ME? – AN INTRODUCTION
 *
 *The extension Formhandler was developed with the requirements of programmers and administrators in mind. The focus was on flexibility, so Formhandler can be used to build any kind of form in a TYPO3 project.
 *
 *However, Formhandler is currently not being delivered with a wizard that enables the building of forms via a fancy GUI in the TYPO3 backend. Keep on reading if you are not deterred by the lack of GUI and find out if Formhandler is right for you:
 *
 *
 *.. toctree::
 *   :maxdepth: 2
 *   :hidden:
 *
 *   Installation/Index
 *   Migration/Index
 *   GeneralOptions/Index
 *TocTreeInsert
 *
 *.. Meta Menu
 *
 *.. toctree::
 *   :hidden:
 *
 *Documentation:End
 */
/** Documentation:Start:Installation/Index.rst.
 *
 *.. _installation:
 *
 *============
 *Installation
 *============
 *
 *1.  Include as composer dependency using
 *
 *    .. code-block:: bash
 *
 *        composer require jakota/formhandler
 *
 *2.  Run
 *
 *    .. code-block:: bash
 *
 *        composer install
 *
 *    to generate the vendor class autoloader.
 *
 *3.  The classes from `JAKOTA.Formhandler` can now be used in your composer project.
 *
 *4.  Include the Formhander TypoScript to your Main TypoScript template.
 *
 *Documentation:End
 */
/** Documentation:Start:Migration/Index.rst.
 *
 *.. _migration:
 *
 *=========
 *Migration
 *=========
 *
 *
 *Documentation:End
 */
/** Documentation:Start:GeneralOptions/Index.rst.
 *
 *.. _general-options:
 *
 *===============
 *General Options
 *===============
 *
 *:ref:`Settings`
 *  All forms are build via TypoScript as predefined forms.
 *
 *:ref:`Predefined-Form`
 *  Predefine form settings and make them selectable in plugin record.
 *
 *:ref:`FileUploadSettings`
 *  Settings to handle file uploads.
 *
 *:ref:`Step`
 *  Multistep forms settings
 *
 *.. toctree::
 *   :maxdepth: 2
 *   :hidden:
 *
 *   Settings
 *   PredefinedForm
 *   FileUploadSettings
 *   Step
 *
 *Documentation:End
 */
/** Documentation:Start:GeneralOptions/Settings.rst.
 *
 *.. _settings:
 *
 *========
 *Settings
 *========
 *
 *All forms are build via TypoScript as predefined forms.
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **TypoScript Path**
 *     - plugin.tx_formhandler_form.settings
 *
 *..  code-block:: typoscript
 *
 *    Example Code:
 *
 *    plugin.tx_formhandler_form.settings {
 *      admin {
 *        bccEmail =
 *        bccName =
 *        ccEmail =
 *        ccName =
 *        replyToEmail =
 *        replyToName =
 *        senderEmail =
 *        senderName =
 *        subject =
 *        toEmail =
 *      }
 *      predefinedForm {
 *        formId1 {
 *        }
 *        formId2 {
 *        }
 *        formId3 {
 *        }
 *      }
 *      redirectPage = 12
 *      requiredFields = 1.customer.firstname, 1.customer.lastname
 *      responseType = html
 *      user {
 *        bccEmail =
 *        bccName =
 *        ccEmail =
 *        ccName =
 *        replyToEmail =
 *        replyToName =
 *        senderEmail =
 *        senderName =
 *        subject =
 *        toEmail =
 *      }
 *    }
 *
 ***Properties**
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **admin**
 *     - See :ref:`MailFinisher`
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - MailModel
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **predefinedForm**
 *     - See :ref:`Predefined-Form`
 *   * -
 *     -
 *   * - *Mandatory*
 *     - True
 *   * - *Data Type*
 *     - Array<String, FormModel>
 *   * - *Note*
 *     - The key String of Array<String, FormModel> must be unique.
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **redirectPage**
 *     - Page UID to redirect to after successful form submission.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - True (only if :ref:`RedirectFinisher` is set)
 *   * - *Data Type*
 *     - Integer
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **requiredFields**
 *     - Mandatory fields (enter names of form fields separated by ",")
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - String
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **responseType**
 *     - Determents the form rendering either as HTML or JSON for headless response.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - True
 *   * - *Data Type*
 *     - String
 *   * - *Supported values*
 *     - html, json
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **user**
 *     - See :ref:`MailFinisher`
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - MailModel
 *
 *Documentation:End
 */
class FormController extends ActionController {
  /** @var array<string, bool> */
  protected $fieldsRequired = [];

  protected FormModel $formConfig;

  protected JsonResponseModel $jsonResponse;

  /** @var array<string, mixed> */
  protected array $parsedBody;

  public function __construct(
    protected readonly PageRepository $pageRepository
  ) {
  }

  /**
   * Show form.
   */
  public function formAction(): ResponseInterface {
    // Load form settings
    $this->formConfig = GeneralUtility::makeInstance(FormModel::class, $this->settings);

    if (!$this->formConfigValid()) {
      // TODO: Return with error
    }
    $this->formConfig->debugMessage(
      key: 'Form config',
      data: $this->formConfig,
    );

    $this->formConfig->site = $this->request->getAttribute('site');
    $this->parsedBody = (array) $this->request->getParsedBody();
    $queryParams = (array) $this->request->getQueryParams();

    if (is_array($queryParams[FormhandlerExtensionConfig::EXTENSION_KEY] ?? false)) {
      if (isset($queryParams[FormhandlerExtensionConfig::EXTENSION_KEY]['removeFile'])) {
        $this->parsedBody[FormhandlerExtensionConfig::EXTENSION_KEY]['removeFile'] = strval($queryParams[FormhandlerExtensionConfig::EXTENSION_KEY]['removeFile']);
      }
      if (isset($queryParams[FormhandlerExtensionConfig::EXTENSION_KEY]['removeFileField'])) {
        $this->parsedBody[FormhandlerExtensionConfig::EXTENSION_KEY]['removeFileField'] = strval($queryParams[FormhandlerExtensionConfig::EXTENSION_KEY]['removeFileField']);
      }
      if (isset($queryParams[FormhandlerExtensionConfig::EXTENSION_KEY]['randomId'])) {
        $this->parsedBody[FormhandlerExtensionConfig::EXTENSION_KEY]['randomId'] = strval($queryParams[FormhandlerExtensionConfig::EXTENSION_KEY]['randomId']);
      }
      if (isset($queryParams[FormhandlerExtensionConfig::EXTENSION_KEY]['step'])) {
        $this->parsedBody[FormhandlerExtensionConfig::EXTENSION_KEY]['step'] = intval($queryParams[FormhandlerExtensionConfig::EXTENSION_KEY]['step']);
      }
    }

    if (is_array($this->parsedBody[FormhandlerExtensionConfig::EXTENSION_KEY] ?? false)) {
      $this->formConfig->randomId = strval($this->parsedBody[FormhandlerExtensionConfig::EXTENSION_KEY]['randomId'] ?? '');
    }

    // Check if form session exists or start new if first form access
    $this->formSession();

    if (null !== ($response = $this->processFileRemoval())) {
      return $response;
    }

    $this->mergeParsedBodyWithSession();

    $this->initInterceptors();

    // TODO: Add AjaxHandler

    $this->initJsonResponse();

    if ($this->formSubmitted()) {
      $this->processUploadedFiles();

      if ($this->validators()) {
        // Check for last step before changing step count
        $isLast = $this->formStepIsLast();

        $this->formStepChange();

        if ($isLast) {
          $this->saveInterceptors();
          $this->loggers();

          $response = $this->finishers();

          // Reset form session
          $this->formConfig->session->reset()->start();

          if (null !== $response) {
            if ('json' == $this->formConfig->responseType) {
              $this->jsonResponse->success = true;

              // TODO: Use new model to check for Response type and Finisher name so headless knows which Finisher returned
              if ($response instanceof RedirectResponse) {
                $this->jsonResponse->redirectPage = $response->getHeaderLine('location');
                $this->jsonResponse->redirectCode = $response->getStatusCode();
              }

              return $this->jsonResponse(json_encode($this->jsonResponse) ?: '{}');
            }

            return $response;
          }
          if ('json' == $this->formConfig->responseType) {
            $this->jsonResponse->success = true;

            return $this->jsonResponse(json_encode($this->jsonResponse) ?: '{}');
          }
        }
      }

      return new RedirectResponse(
        '#'.$this->formConfig->formId
      );
    }

    $this->prepareFormSets();

    if ('json' == $this->formConfig->responseType) {
      $this->jsonResponse->steps = $this->formConfig->steps;
      $this->jsonResponse->fieldsErrors = $this->formConfig->fieldsErrors;
      $this->jsonResponse->fieldSets = $this->formConfig->fieldSets;
      $this->jsonResponse->fileUpload = $this->formConfig->fileUpload;
      $this->jsonResponse->formUploads = $this->formConfig->formUploads;
      $this->jsonResponse->formValues = $this->formConfig->formValues;

      $this->formConfig->processDebugLog();

      return $this->jsonResponse(json_encode($this->jsonResponse) ?: '{}');
    }

    foreach ($this->formConfig->steps[$this->formConfig->step]->validators as $validator) {
      foreach ($validator->fields as $field) {
        $this->prepareFieldsRequired('['.$this->formConfig->step.']', $field);
      }
    }

    $debugOutput = $this->formConfig->processDebugLog();

    // Prepare output
    $this->view->assignMultiple(
      [
        'debugOutput' => $debugOutput,
        'extensionKey' => FormhandlerExtensionConfig::EXTENSION_KEY,
        'fieldsRequired' => $this->fieldsRequired,
        'fieldsErrors' => $this->formConfig->fieldsErrors,
        'fieldSets' => $this->formConfig->fieldSets,
        'fileUpload' => $this->formConfig->fileUpload,
        'formId' => $this->formConfig->formId,
        'formName' => $this->formConfig->formName,
        'formUploads' => $this->formConfig->formUploads,
        'formUrl' => $this->formConfig->formUrl,
        'formValuesPrefix' => $this->formConfig->formValuesPrefix,
        'langFileDefault' => $this->formConfig->langFileDefault,
        'selectsOptions' => $this->formConfig->selectsOptions,
        'step' => $this->formConfig->step,
        'steps' => $this->formConfig->steps,
        'templateForm' => $this->formConfig->steps[$this->formConfig->step]->templateForm(),
        'formValues' => $this->formConfig->formValues ?? [],
      ]
    );

    // TODO: Delete me, once done
    echo $this->view->render();

    // TODO: Delete me, once done
    exit;

    // TODO: Activate me, once done
    // return $this->htmlResponse();
  }

  // TODO: Change return type to new model of Response and Finisher name so headless knows which Finisher returned
  private function finishers(): ?Response {
    foreach ($this->formConfig->finishers as $finisher) {
      GeneralUtility::makeInstance($finisher->class())->process($this->formConfig, $finisher);
      if ($finisher->returns) {
        return $finisher->response;
      }
    }

    return null;
  }

  private function formConfigValid(): bool {
    // TODO: Check for valid form config
    // check if template is set
    return true;
  }

  private function formSession(): void {
    $this->formConfig->session = GeneralUtility::makeInstance(Typo3Session::class)
      ->init($this->formConfig)
      ->start()
    ;

    $this->formConfig->debugMessage(
      key: 'Session first start',
      data: $this->formConfig->firstAccess,
    );

    if ($this->formConfig->session->exists()) {
      $selectsOptions = $this->formConfig->session->get('selectsOptions');
      if (is_array($selectsOptions)) {
        $this->formConfig->selectsOptions = $selectsOptions;
      }

      $fieldsErrors = $this->formConfig->session->get('fieldsErrors');
      if (is_array($fieldsErrors)) {
        $this->formConfig->fieldsErrors = $fieldsErrors;
      }

      $this->formConfig->step = intval(
        (
          (array) ($this->parsedBody[FormhandlerExtensionConfig::EXTENSION_KEY] ?? [])
        )['step'] ??
        $this->formConfig->session->get('step') ?: 1
      );

      $this->formConfig->formValues = (array) ($this->formConfig->session->get('formValues') ?: []);

      $formUploads = $this->formConfig->session->get('formUploads');
      if ($formUploads instanceof FormUpload) {
        $this->formConfig->formUploads = $formUploads;
      }
    } else {
      // Form session is invalid or first form access reset form
      if (!$this->formConfig->firstAccess) {
        // Form session is invalid create new one
        $this->formConfig->session->reset()->start();
      }

      $this->formConfig->step = 1;
      $this->formConfig->formValues = [];

      $this->parsedBody[FormhandlerExtensionConfig::EXTENSION_KEY] = [];
      $this->parsedBody[FormhandlerExtensionConfig::EXTENSION_KEY]['submitted'] = false;
      $this->parsedBody[FormhandlerExtensionConfig::EXTENSION_KEY]['randomId'] = $this->formConfig->randomId;
      $this->parsedBody[FormhandlerExtensionConfig::EXTENSION_KEY]['step'] = $this->formConfig->step;
      $this->parsedBody[$this->formConfig->formValuesPrefix] = $this->formConfig->formValues;

      // Execute PreProcessor
      foreach ($this->formConfig->preProcessors as $preProcessor) {
        GeneralUtility::makeInstance($preProcessor->class())->process($this->formConfig, $preProcessor);
      }

      $this->formConfig->session->setMultiple(
        [
          'selectsOptions' => $this->formConfig->selectsOptions,
          'formValues' => $this->formConfig->formValues,
          'formUploads' => $this->formConfig->formUploads,
          'step' => $this->formConfig->step,
        ]
      );
    }
  }

  private function formStepChange(): void {
    if (
      is_array($this->parsedBody[$this->formConfig->formValuesPrefix] ?? false)
      && is_array($this->parsedBody[$this->formConfig->formValuesPrefix]['step'] ?? false)
      && isset($this->parsedBody[$this->formConfig->formValuesPrefix]['step']['prev'])
    ) {
      $this->formConfig->step = $this->formConfig->step > 1 ? $this->formConfig->step - 1 : 1;
    } else {
      $this->formConfig->step = !$this->formStepIsLast() ? $this->formConfig->step + 1 : $this->formConfig->step;
    }

    $this->formConfig->session->set('step', $this->formConfig->step);
  }

  private function formStepIsLast(): bool {
    return count($this->formConfig->steps) == $this->formConfig->step;
  }

  private function formSubmitted(): bool {
    if (is_array($this->parsedBody[FormhandlerExtensionConfig::EXTENSION_KEY] ?? false)) {
      return filter_var($this->parsedBody[FormhandlerExtensionConfig::EXTENSION_KEY]['submitted'] ?? false, FILTER_VALIDATE_BOOLEAN);
    }

    return false;
  }

  private function initInterceptors(): void {
    foreach ($this->formConfig->initInterceptors as $initInterceptor) {
      GeneralUtility::makeInstance($initInterceptor->class())->process($this->formConfig, $initInterceptor);
    }
  }

  private function initJsonResponse(): void {
    if ('json' == $this->formConfig->responseType) {
      $this->jsonResponse = new JsonResponseModel();
      $this->jsonResponse->extensionKey = FormhandlerExtensionConfig::EXTENSION_KEY;
      $this->jsonResponse->formId = $this->formConfig->formId;
      $this->jsonResponse->formName = $this->formConfig->formName;
      $this->jsonResponse->formUrl = $this->formConfig->formUrl;
      $this->jsonResponse->formValuesPrefix = $this->formConfig->formValuesPrefix;
      $this->jsonResponse->requiredFields = $this->formConfig->requiredFields;
      $this->jsonResponse->selectsOptions = $this->formConfig->selectsOptions;
      $this->jsonResponse->step = $this->formConfig->step;
    }
  }

  private function loggers(): void {
    foreach ($this->formConfig->loggers as $logger) {
      GeneralUtility::makeInstance($logger->class())->process($this->formConfig, $logger);
    }
  }

  private function mergeParsedBodyWithSession(): void {
    if (!is_array($this->parsedBody[$this->formConfig->formValuesPrefix] ?? false)) {
      return;
    }

    $this->formConfig->formValues[strval($this->formConfig->step)] = $this->parsedBody[$this->formConfig->formValuesPrefix][$this->formConfig->step];
    $this->formConfig->session->set('formValues', $this->formConfig->formValues);

    $this->formConfig->debugMessage(
      key: 'Merge parsedBody with Session',
      data: $this->formConfig->formValues,
    );

    // TODO: Add check if step number is valid
    if (is_array($this->parsedBody[FormhandlerExtensionConfig::EXTENSION_KEY])) {
      $this->formConfig->step = intval($this->parsedBody[FormhandlerExtensionConfig::EXTENSION_KEY]['step'] ?? 1);
    }
    $this->formConfig->session->set('step', $this->formConfig->step);

    $this->formConfig->debugMessage(
      key: 'Step number in Session',
      data: $this->formConfig->step,
    );
  }

  private function prepareFieldsRequired(string $fieldNamePath, FieldModel $field): void {
    $fieldNamePath .= '['.$field->name.']';
    foreach ($field->errorChecks as $errorCheck) {
      // TODO: Maybe add $errorCheck->isRequired()?
      if ('Required' == $errorCheck->name) {
        $this->fieldsRequired[$fieldNamePath] = true;
      }
    }
    foreach ($field->fields as $field) {
      $this->prepareFieldsRequired($fieldNamePath, $field);
    }
  }

  private function prepareFormSets(): void {
    $this->formConfig->fieldSets[] = new FieldSetModel('submitted', 'true');
    $this->formConfig->fieldSets[] = new FieldSetModel('randomId', $this->formConfig->randomId);
    $this->formConfig->fieldSets[] = new FieldSetModel('step', (string) $this->formConfig->step);
  }

  /**
   * @param array<int|string, mixed> $uploadsName
   * @param array<int|string, mixed> $uploadsTempName
   * @param array<int|string, mixed> $uploadsType
   * @param array<int|string, mixed> $uploadsSize
   * @param array<string, mixed>     $flatFilesArray
   */
  private function prepareUploadedFiles(
    array $uploadsName,
    array $uploadsTempName,
    array $uploadsType,
    array $uploadsSize,
    string $fieldNamePath = '',
    array &$flatFilesArray = [],
  ): void {
    foreach ($uploadsName as $key => $value) {
      if (is_array($value)) {
        $this->prepareUploadedFiles(
          $uploadsName[$key], // @phpstan-ignore-line
          $uploadsTempName[$key], // @phpstan-ignore-line
          $uploadsType[$key], // @phpstan-ignore-line
          $uploadsSize[$key], // @phpstan-ignore-line
          empty($fieldNamePath) ? "[{$key}]" : $fieldNamePath."[{$key}]",
          $flatFilesArray,
        );
      } elseif (!empty($value)) {
        $flatFilesArray[$fieldNamePath][$key]['name'] = $value;
        $flatFilesArray[$fieldNamePath][$key]['tmp_name'] = $uploadsTempName[$key];
        $flatFilesArray[$fieldNamePath][$key]['type'] = $uploadsType[$key];
        $flatFilesArray[$fieldNamePath][$key]['size'] = $uploadsSize[$key];
      }
    }
  }

  /**
   * Removes files from the internal file storage.
   */
  private function processFileRemoval(): ?RedirectResponse {
    if (is_array($this->parsedBody[FormhandlerExtensionConfig::EXTENSION_KEY])) {
      $removeFile = strval($this->parsedBody[FormhandlerExtensionConfig::EXTENSION_KEY]['removeFile'] ?? '');
      $removeFileField = strval($this->parsedBody[FormhandlerExtensionConfig::EXTENSION_KEY]['removeFileField'] ?? '');

      if (empty($removeFile) || empty($removeFileField)) {
        return null;
      }

      foreach ($this->formConfig->formUploads->files[$removeFileField] as $key => $file) {
        if ($file->name == $removeFile) {
          $this->formConfig->formUploads->fileTotalSize -= $file->size;
          --$this->formConfig->formUploads->fileTotalCount;

          if (file_exists($file->temp) && is_writable($file->temp)) {
            unlink($file->temp);
          }

          array_splice($this->formConfig->formUploads->files[$removeFileField], $key, 1);

          // Save formUploads to session
          $this->formConfig->session->set('formUploads', $this->formConfig->formUploads);

          break;
        }
      }

      return new RedirectResponse(
        $this->uriBuilder->build().'#'.$this->formConfig->formId
      );
    }

    return null;
  }

  /**
   * Processes uploaded files, moves them to a temporary upload folder, renames them if they already exist and
   * stores the information in user session.
   */
  private function processUploadedFiles(): void {
    // TODO: Create task to delete old temp files
    // TODO: Create task to delete deleted mails in BE and uploaded files

    // Check fo uploaded files
    if (empty($_FILES) || !isset($_FILES[$this->formConfig->formValuesPrefix]) || !is_array($_FILES[$this->formConfig->formValuesPrefix]) || !isset($_FILES[$this->formConfig->formValuesPrefix]['name'])) {
      return;
    }

    // Flatten the $_FILES array
    $flatFilesArray = [];
    $this->prepareUploadedFiles(
      $_FILES[$this->formConfig->formValuesPrefix]['name'],
      $_FILES[$this->formConfig->formValuesPrefix]['tmp_name'],
      $_FILES[$this->formConfig->formValuesPrefix]['type'],
      $_FILES[$this->formConfig->formValuesPrefix]['size'],
      '',
      $flatFilesArray,
    );

    // Create temp folder if not exits
    $tempFolder = getcwd().'/uploads/'.FormhandlerExtensionConfig::EXTENSION_PLUGIN_SIGNATURE.'/temp/'.$this->formConfig->randomId;

    if (!file_exists($tempFolder)) {
      GeneralUtility::mkdir_deep($tempFolder);
    }

    if (!file_exists($tempFolder)) {
      // Log error if upload folder could not be created
      $this->formConfig->debugMessage(
        key: 'folder_doesnt_exist',
        data: [$tempFolder],
        severity: Severity::Error
      );

      // TODO: Hold with error
      return;
    }

    // Loop all upload fields
    foreach ($flatFilesArray as $fieldNamePath => $fieldFiles) {
      $fieldNamePath = strval($fieldNamePath);

      // Loop all upload files fo a field
      foreach ($fieldFiles as $fieldFile) {
        // Rename file name if needed
        $fieldFile['name'] = Utility::doFileNameReplace($this->formConfig, $fieldFile['name']);

        // Check if new uploaded file already exits for this form
        $exists = file_exists($tempFolder.'/'.$fieldFile['name']);

        if (!$exists || 'replace' === $this->formConfig->fileUpload->withSameName || 'append' === $this->formConfig->fileUpload->withSameName) {
          // Extract filename if . exists
          $filename = substr($fieldFile['name'], 0, strrpos($fieldFile['name'], '.') ?: strlen($fieldFile['name']));

          if (strlen($filename) > 0) {
            $ext = substr($fieldFile['name'], strrpos($fieldFile['name'], '.') ?: strlen($fieldFile['name']));
            $suffix = 1;

            // build file name
            $uploadedFileName = $filename.$ext;

            if ($exists && 'append' == $this->formConfig->fileUpload->withSameName) {
              // rename if exists
              while (file_exists($tempFolder.'/'.$uploadedFileName)) {
                $uploadedFileName = $filename.'_'.$suffix.$ext;
                ++$suffix;
              }
            }

            // Mode the file and fix permissions
            move_uploaded_file($fieldFile['tmp_name'], $tempFolder.'/'.$uploadedFileName);
            GeneralUtility::fixPermissions($tempFolder.'/'.$uploadedFileName);

            if ($exists && 'replace' == $this->formConfig->fileUpload->withSameName) {
              // Replace processed upload with new uploaded file
              foreach ($this->formConfig->formUploads->files[$fieldNamePath] as &$file) {
                if ($file->name == $uploadedFileName) {
                  $this->formConfig->formUploads->fileTotalSize -= $file->size;

                  $file->name = $uploadedFileName;
                  $file->size = $fieldFile['size'];
                  $file->temp = $tempFolder.'/'.$uploadedFileName;
                  $file->type = $fieldFile['type'];
                  $this->formConfig->formUploads->fileTotalSize += $file->size;

                  break;
                }
              }
            } else {
              // Add new upload to processed uploads
              $formUploadFile = new FormUploadFile();
              $formUploadFile->name = $uploadedFileName;
              $formUploadFile->size = $fieldFile['size'];
              $formUploadFile->temp = $tempFolder.'/'.$uploadedFileName;
              $formUploadFile->type = $fieldFile['type'];

              $this->formConfig->formUploads->files[$fieldNamePath][] = $formUploadFile;
              ++$this->formConfig->formUploads->fileTotalCount;
              $this->formConfig->formUploads->fileTotalSize += $formUploadFile->size;
            }
          }
        }
      }
    }

    // Save formUploads to session
    $this->formConfig->session->set('formUploads', $this->formConfig->formUploads);
  }

  private function saveInterceptors(): void {
    foreach ($this->formConfig->saveInterceptors as $saveInterceptor) {
      GeneralUtility::makeInstance($saveInterceptor->class())->process($this->formConfig, $saveInterceptor);
    }
  }

  private function validators(): bool {
    $isValid = true;
    $this->formConfig->fieldsErrors = [];

    foreach ($this->formConfig->steps[$this->formConfig->step]->validators as $validator) {
      if (!GeneralUtility::makeInstance($validator->class())->process($this->formConfig, $validator)) {
        $isValid = false;
      }
    }

    // TODO: Add Check for new total file count and size if set

    $this->formConfig->session->set('fieldsErrors', $this->formConfig->fieldsErrors);

    return $isValid;
  }
}
