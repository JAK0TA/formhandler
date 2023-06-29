<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config;

use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use Typoheads\Formhandler\Debugger\AbstractDebugger;
use Typoheads\Formhandler\Definitions\FormhandlerExtensionConfig;
use Typoheads\Formhandler\Definitions\Severity;
use Typoheads\Formhandler\Domain\Model\Config\Debugger\AbstractDebuggerModel;
use Typoheads\Formhandler\Domain\Model\Config\Finisher\AbstractFinisherModel;
use Typoheads\Formhandler\Domain\Model\Config\Interceptor\AbstractInterceptorModel;
use Typoheads\Formhandler\Domain\Model\Config\Logger\AbstractLoggerModel;
use Typoheads\Formhandler\Domain\Model\Config\PreProcessor\AbstractPreProcessorModel;
use Typoheads\Formhandler\Session\AbstractSession;
use Typoheads\Formhandler\Utility\Utility;

class FormModel {
  public MailModel $admin;

  /** @var FieldSetModel[] */
  public array $fieldSets = [];

  /** @var array<string, SelectOptionModel[]> */
  public array $fieldsSelectOptions = [];

  /** @var AbstractFinisherModel[] */
  public array $finishers = [];

  public string $formId = '';

  public string $formName = '';

  public string $formUrl = '';

  /** @var array<string, mixed> */
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

  /** @var array<string, array<int, array{message: string, severity: Severity, data: array<int|string, mixed>|object|string}>> */
  private array $debugLog = [];

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    // Get flexform settings
    $this->admin = GeneralUtility::makeInstance(MailModel::class, $settings['admin'] ?? []);
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

      // Get form debugger
      foreach ($settings['predefinedForms'][$this->predefinedForm]['debuggers'] ?? [] as $debugger) {
        if (empty($debugger['model'])) {
          continue;
        }

        /** @var AbstractDebuggerModel $debuggerModel */
        $debuggerModel = GeneralUtility::makeInstance($utility::classString(strval($debugger['model']), 'Typoheads\\Formhandler\\Domain\\Model\\Config\\Debugger\\'), $debugger['config'] ?? []);

        $this->debuggers[] = GeneralUtility::makeInstance($debuggerModel->class(), $this, $debuggerModel);
      }

      // Get form logger
      foreach ($settings['predefinedForms'][$this->predefinedForm]['loggers'] ?? [] as $logger) {
        if (empty($logger['model'])) {
          continue;
        }

        /** @var AbstractLoggerModel $loggerModel */
        $loggerModel = GeneralUtility::makeInstance($utility::classString(strval($logger['model']), 'Typoheads\\Formhandler\\Domain\\Model\\Config\\Logger\\'), $logger['config'] ?? []);

        $this->loggers[] = $loggerModel;
      }

      // Get form PreProcessor
      foreach ($settings['predefinedForms'][$this->predefinedForm]['preProcessors'] ?? [] as $preProcessor) {
        if (empty($preProcessor['model'])) {
          continue;
        }

        /** @var AbstractPreProcessorModel $preProcessorModel */
        $preProcessorModel = GeneralUtility::makeInstance($utility::classString(strval($preProcessor['model']), 'Typoheads\\Formhandler\\Domain\\Model\\Config\\PreProcessor\\'), $preProcessor['config'] ?? []);

        $this->preProcessors[] = $preProcessorModel;
      }

      // Get form Init Interceptor
      foreach ($settings['predefinedForms'][$this->predefinedForm]['initInterceptors'] ?? [] as $initInterceptor) {
        if (empty($initInterceptor['model'])) {
          continue;
        }

        /** @var AbstractInterceptorModel $initInterceptorModel */
        $initInterceptorModel = GeneralUtility::makeInstance($utility::classString(strval($initInterceptor['model']), 'Typoheads\\Formhandler\\Domain\\Model\\Config\\Interceptor\\'), $initInterceptor['config'] ?? []);

        $this->initInterceptors[] = $initInterceptorModel;
      }

      // Get form Save Interceptor
      foreach ($settings['predefinedForms'][$this->predefinedForm]['saveInterceptors'] ?? [] as $saveInterceptor) {
        if (empty($saveInterceptor['model'])) {
          continue;
        }

        /** @var AbstractInterceptorModel $saveInterceptorModel */
        $saveInterceptorModel = GeneralUtility::makeInstance($utility::classString(strval($saveInterceptor['model']), 'Typoheads\\Formhandler\\Domain\\Model\\Config\\Interceptor\\'), $saveInterceptor['config'] ?? []);

        $this->saveInterceptors[] = $saveInterceptorModel;
      }

      // Get form steps
      foreach ($settings['predefinedForms'][$this->predefinedForm]['steps'] ?? [] as $stepKey => $step) {
        if (empty($step) || !is_array($step)) {
          continue;
        }

        $this->steps[intval($stepKey)] = GeneralUtility::makeInstance(StepModel::class, $step, $templateForm);
      }
      if (0 == count($this->steps)) {
        $this->steps[1] = GeneralUtility::makeInstance(StepModel::class, [], $templateForm);
      }

      foreach ($settings['predefinedForms'][$this->predefinedForm]['finishers'] ?? [] as $finisher) {
        if (empty($finisher['model'])) {
          continue;
        }

        /** @var AbstractFinisherModel $finisherModel */
        $finisherModel = GeneralUtility::makeInstance($utility::classString(strval($finisher['model']), 'Typoheads\\Formhandler\\Domain\\Model\\Config\\Finisher\\'), $finisher['config'] ?? []);

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
   * @param Severity                                              $severity   The severity of the message. Valid values are Severity::Info, Severity::Warning and Severity::Error
   * @param array<int|string, mixed>|bool|float|int|object|string $data       Additional debug data (e.g. the array of GET/POST values)
   */
  public function debugMessage(string $key, array $printfArgs = [], Severity $severity = Severity::Info, array|bool|float|int|object|string $data = []): void {
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

  public function processDebugLog(): void {
    foreach ($this->debuggers as $debugger) {
      $debugger->processDebugLog($this->debugLog);
    }
  }
}
