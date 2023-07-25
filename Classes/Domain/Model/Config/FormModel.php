<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\Domain\Model\Config;

use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use Typoheads\Formhandler\Debugger\AbstractDebugger;
use Typoheads\Formhandler\Definitions\FormhandlerExtensionConfig;
use Typoheads\Formhandler\Definitions\Severity;
use Typoheads\Formhandler\Domain\Model\Config\Debugger\AbstractDebuggerModel;
use Typoheads\Formhandler\Domain\Model\Config\Finisher\AbstractFinisherModel;
use Typoheads\Formhandler\Domain\Model\Config\GeneralOptions\FileUploadModel;
use Typoheads\Formhandler\Domain\Model\Config\Interceptor\AbstractInterceptorModel;
use Typoheads\Formhandler\Domain\Model\Config\Logger\AbstractLoggerModel;
use Typoheads\Formhandler\Domain\Model\Config\PreProcessor\AbstractPreProcessorModel;
use Typoheads\Formhandler\Session\AbstractSession;
use Typoheads\Formhandler\Utility\Utility;

/** Documentation:Start:GeneralOptions/PredefinedForm.rst.
 *
 *.. _predefined-form:
 *
 *===============
 *Predefined Form
 *===============
 *
 *Predefine form settings and make them selectable in plugin record.
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **TypoScript Path**
 *     - plugin.tx_formhandler_form.settings.predefinedForms.FormName
 *
 *..  code-block:: typoscript
 *
 *    Example Code:
 *
 *    plugin.tx_formhandler_form.settings.predefinedForms.devExample {
 *      formId = DevExampleForm
 *      formName = Dev Example Form
 *      formValuesPrefix = DevExampleForm
 *      langFileDefault = locallang_example_form.xlf
 *      templateForm = DevExample/Default
 *      templateMailHtml = DevExample/MailHtml
 *      templateMailText = DevExample/MailText
 *
 *      fileUpload {
 *      }
 *
 *      debuggers {
 *      }
 *
 *      steps {
 *        1 {
 *          templateForm = DevExampleForm/DevExampleHTMLStep1
 *          validators {
 *            DefaultValidator {
 *              model = DefaultValidator
 *              config {
 *                messageLimit = 1
 *                messageLimits {
 *                  1.customer.email = 2
 *                }
 *                fields {
 *                  customer.fields {
 *                    firstname.errorChecks {
 *                      required {
 *                        model = Required
 *                      }
 *                      lengthMax {
 *                        model = LengthMax
 *                        lengthMax = 20
 *                      }
 *                    }
 *                    lastname.errorChecks {
 *                      required {
 *                        model = Required
 *                      }
 *                      lengthMax {
 *                        model = LengthMax
 *                        lengthMax = 20
 *                      }
 *                    }
 *                    streetAddress.errorChecks {
 *                      required {
 *                        model = Required
 *                      }
 *                    }
 *                    postalCode.errorChecks {
 *                      required {
 *                        model = Required
 *                      }
 *                    }
 *                    city.errorChecks {
 *                      required {
 *                        model = Required
 *                      }
 *                      lengthMax {
 *                        model = LengthMax
 *                        lengthMax = 70
 *                      }
 *                    }
 *                    country.errorChecks {
 *                      required {
 *                        model = Required
 *                      }
 *                    }
 *                    telephone.errorChecks {
 *                      required {
 *                        model = Required
 *                      }
 *                      lengthMax {
 *                        model = LengthMax
 *                        lengthMax = 20
 *                      }
 *                    }
 *                    email.errorChecks {
 *                      required {
 *                        model = Required
 *                      }
 *                      lengthMax {
 *                        model = LengthMax
 *                        lengthMax = 50
 *                      }
 *                      email {
 *                        model = Email
 *                      }
 *                    }
 *                  }
 *                }
 *              }
 *            }
 *          }
 *        }
 *      }
 *
 *      finishers {
 *        Mail {
 *          model = MailFinisher
 *        }
 *        Redirect {
 *          model = RedirectFinisher
 *          config {
 *            returns = true
 *            correctRedirectUrl = false
 *            additionalParams {
 *              postal_code = 1.customer.postalCode
 *              queryParam2 = valueIfNotFoundAsFieldName
 *            }
 *          }
 *        }
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
 *   * - **formId**
 *     - Value of the id attribute of the form tag.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - True
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
 *   * - **formName**
 *     - Value of the name shown in the dropdown list.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - True
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
 *   * - **formValuesPrefix**
 *     - | Prefix of form fields. Use this if you use a prefix for your forms to avoid conflicts with other plugins.
 *       | Settings this option you will be able to use only the fieldname in all markers and do not need to add prefix.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - String
 *   * - *Default*
 *     - tx_formhandler_form
 *   * - *Note*
 *     - It is highly recommended to use this setting!
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **langFileDefault**
 *     - Path to default language file, can be altered as parameter by the form fields.
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
 *   * - **fileUpload**
 *     - Settings to handle file uploads.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - :ref:`FileUpload <FileUpload>`
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **debuggers**
 *     - A list of :ref:`Debuggers` for the predefined forms.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - Array<String, :ref:`Debugger <Debuggers>`>
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **steps**
 *     - | You can split a form into as many steps as you like and add as many :ref:`Validators` as you like to each step,
 *       | but even if the form has just one step it must be defined to add :ref:`Validators`.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - True (Only if a form has needs :ref:`Validators`, otherwise not.)
 *   * - *Data Type*
 *     - Array<Integer, :ref:`Step`>
 *   * - *Note*
 *     - The key Integer in Array<Integer, :ref:`Step`> starts at 1 for first step.
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **finishers**
 *     - A list of :ref:`Finishers` for the predefined forms.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - Array<String, :ref:`Finisher <Finishers>`>
 *
 *Documentation:End
 */
class FormModel {
  public MailModel $admin;

  /** @var array<string, string[]> */
  public array $disableErrorCheckFields = [];

  /** @var array<string, string[]> */
  public array $fieldsErrors = [];

  /** @var FieldSetModel[] */
  public array $fieldSets = [];

  public FileUploadModel $fileUpload;

  /** @var AbstractFinisherModel[] */
  public array $finishers = [];

  public bool $firstAccess = true;

  public string $formId = '';

  public string $formName = '';

  public FormUpload $formUploads;

  public string $formUrl = '';

  /** @var mixed[] */
  public array $formValues;

  public string $formValuesPrefix = '';

  /** @var AbstractInterceptorModel[] */
  public array $initInterceptors = [];

  public string $langFileDefault = '';

  /** @var AbstractLoggerModel[] */
  public array $loggers = [];

  public string $predefinedForm = '';

  /** @var AbstractPreProcessorModel[] */
  public array $preProcessors = [];

  public string $randomId = '';

  public int $redirectPage = 0;

  public string $requiredFields = '';

  public string $responseType = 'html';

  /** @var AbstractInterceptorModel[] */
  public array $saveInterceptors = [];

  /** @var array<string, SelectOptionModel[]> */
  public array $selectsOptions = [];

  public AbstractSession $session;

  public ?Site $site;

  public int $step = 1;

  /** @var StepModel[] */
  public array $steps = [];

  public string $templateMailHtml = '';

  public string $templateMailText = '';

  public MailModel $user;

  /** @var AbstractDebugger[] */
  private array $debuggers = [];

  /** @var array<string, array<int, array{message: string, severity: int, data: array<int|string, mixed>|object|string}>> */
  private array $debugLog = [];

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    // Get flexform settings
    $this->admin = GeneralUtility::makeInstance(MailModel::class, $settings['admin'] ?? []);
    $this->formUploads = new FormUpload();
    $this->predefinedForm = strval($settings['predefinedForm'] ?? '');
    $this->redirectPage = intval($settings['redirectPage'] ?? 0);
    $this->requiredFields = strval($settings['requiredFields'] ?? '');
    $this->responseType = strval($settings['responseType'] ?? 'html');
    $this->user = GeneralUtility::makeInstance(MailModel::class, $settings['user'] ?? []);

    if (!empty($this->predefinedForm)
      && isset($settings['predefinedForms'])
      && is_array($settings['predefinedForms'])
      && isset($settings['predefinedForms'][$this->predefinedForm])
      && is_array($settings['predefinedForms'][$this->predefinedForm])
    ) {
      // Get form settings
      $this->formId = strval($settings['predefinedForms'][$this->predefinedForm]['formId'] ?? '');
      $this->formName = strval($settings['predefinedForms'][$this->predefinedForm]['formName'] ?? '');
      $this->formValuesPrefix = strval($settings['predefinedForms'][$this->predefinedForm]['formValuesPrefix'] ?? FormhandlerExtensionConfig::EXTENSION_PLUGIN_SIGNATURE);
      $this->langFileDefault = strval($settings['predefinedForms'][$this->predefinedForm]['langFileDefault'] ?? '');
      $this->templateMailHtml = strval($settings['predefinedForms'][$this->predefinedForm]['templateMailHtml'] ?? '');
      $this->templateMailText = strval($settings['predefinedForms'][$this->predefinedForm]['templateMailText'] ?? '');

      // Get default form template if no step template is set
      $templateForm = strval($settings['predefinedForms'][$this->predefinedForm]['templateForm'] ?? '');

      $utility = GeneralUtility::makeInstance(Utility::class);

      // File upload settings
      $this->fileUpload = GeneralUtility::makeInstance(FileUploadModel::class, $settings['predefinedForms'][$this->predefinedForm]['fileUpload'] ?? []);

      // Get form debugger
      foreach ($settings['predefinedForms'][$this->predefinedForm]['debuggers'] ?? [] as $debugger) {
        if (empty($debugger['model'])) {
          continue;
        }

        /** @var AbstractDebuggerModel $debuggerModel */
        $debuggerModel = GeneralUtility::makeInstance($utility::classString(strval($debugger['model']).'Model', 'Typoheads\\Formhandler\\Domain\\Model\\Config\\Debugger\\'), $debugger['config'] ?? []);

        $this->debuggers[] = GeneralUtility::makeInstance($debuggerModel->class())->init($this, $debuggerModel);
      }

      // Get form logger
      foreach ($settings['predefinedForms'][$this->predefinedForm]['loggers'] ?? [] as $logger) {
        if (empty($logger['model'])) {
          continue;
        }

        /** @var AbstractLoggerModel $loggerModel */
        $loggerModel = GeneralUtility::makeInstance($utility::classString(strval($logger['model']).'Model', 'Typoheads\\Formhandler\\Domain\\Model\\Config\\Logger\\'), $logger['config'] ?? []);

        $this->loggers[] = $loggerModel;
      }

      // Get form PreProcessor
      foreach ($settings['predefinedForms'][$this->predefinedForm]['preProcessors'] ?? [] as $preProcessor) {
        if (empty($preProcessor['model'])) {
          continue;
        }

        /** @var AbstractPreProcessorModel $preProcessorModel */
        $preProcessorModel = GeneralUtility::makeInstance($utility::classString(strval($preProcessor['model']).'Model', 'Typoheads\\Formhandler\\Domain\\Model\\Config\\PreProcessor\\'), $preProcessor['config'] ?? []);

        $this->preProcessors[] = $preProcessorModel;
      }

      // Get form Init Interceptor
      foreach ($settings['predefinedForms'][$this->predefinedForm]['initInterceptors'] ?? [] as $initInterceptor) {
        if (empty($initInterceptor['model'])) {
          continue;
        }

        /** @var AbstractInterceptorModel $initInterceptorModel */
        $initInterceptorModel = GeneralUtility::makeInstance($utility::classString(strval($initInterceptor['model']).'Model', 'Typoheads\\Formhandler\\Domain\\Model\\Config\\Interceptor\\'), $initInterceptor['config'] ?? []);

        $this->initInterceptors[] = $initInterceptorModel;
      }

      // Get form Save Interceptor
      foreach ($settings['predefinedForms'][$this->predefinedForm]['saveInterceptors'] ?? [] as $saveInterceptor) {
        if (empty($saveInterceptor['model'])) {
          continue;
        }

        /** @var AbstractInterceptorModel $saveInterceptorModel */
        $saveInterceptorModel = GeneralUtility::makeInstance($utility::classString(strval($saveInterceptor['model']).'Model', 'Typoheads\\Formhandler\\Domain\\Model\\Config\\Interceptor\\'), $saveInterceptor['config'] ?? []);

        $this->saveInterceptors[] = $saveInterceptorModel;
      }

      // Get form steps
      foreach ($settings['predefinedForms'][$this->predefinedForm]['steps'] ?? [] as $stepKey => $step) {
        if (empty($step) || !is_array($step)) {
          continue;
        }

        $this->steps[intval($stepKey)] = GeneralUtility::makeInstance(StepModel::class, $this, $step, $templateForm);
      }
      if (0 == count($this->steps)) {
        $this->steps[1] = GeneralUtility::makeInstance(StepModel::class, [], $templateForm);
      }

      foreach ($settings['predefinedForms'][$this->predefinedForm]['finishers'] ?? [] as $finisher) {
        if (empty($finisher['model'])) {
          continue;
        }

        /** @var AbstractFinisherModel $finisherModel */
        $finisherModel = GeneralUtility::makeInstance($utility::classString(strval($finisher['model']).'Model', 'Typoheads\\Formhandler\\Domain\\Model\\Config\\Finisher\\'), $finisher['config'] ?? []);

        $this->finishers[] = $finisherModel;
      }
    }
  }

  /**
   * Method to log a debug message.
   * The message will be handled by one or more configured "Debuggers".
   *
   * @param string                                                $key        The message or key in language file (locallang_debug.xlf)
   * @param array<int, null|bool|float|int|string>                $printfArgs if the message contains placeholders for usage with printf, pass the replacement values in this array
   * @param int                                                   $severity   The severity of the message. Valid values are Severity::Info, Severity::Warning and Severity::Error
   * @param array<int|string, mixed>|bool|float|int|object|string $data       Additional debug data (e.g. the array of GET/POST values)
   */
  public function debugMessage(string $key, array $printfArgs = [], int $severity = Severity::Info, array|bool|float|int|object|string $data = []): void {
    if (empty($this->debuggers)) {
      return;
    }

    $message = trim(LocalizationUtility::translate('LLL:EXT:formhandler/Resources/Private/Language/locallang_debug.xlf:'.$key) ?? $key);
    if (count($printfArgs) > 0) {
      $message = vsprintf($message, $printfArgs);
    }

    $data = Utility::recursiveHtmlSpecialChars($data);

    $trace = debug_backtrace();
    $section = '';
    if (isset($trace[1])) {
      $section = strval($trace[1]['class'] ?? '');
    }

    if (empty($section)) {
      return;
    }

    if (!isset($this->debugLog[$section])) {
      $this->debugLog[$section] = [];
    }

    $this->debugLog[$section][] = ['message' => $message, 'severity' => $severity, 'data' => $data];
  }

  public function processDebugLog(): ?string {
    $debugOutput = null;

    foreach ($this->debuggers as $debugger) {
      $debuggerOutput = $debugger->processDebugLog($this->debugLog);
      if (null !== $debuggerOutput) {
        $debugOutput .= $debuggerOutput;
      }
    }

    return $debugOutput;
  }
}
