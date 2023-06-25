<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Typoheads\Formhandler\Domain\Model\Config\Finisher\AbstractFinisher;
use Typoheads\Formhandler\Domain\Model\Config\Logger\AbstractLogger;
use Typoheads\Formhandler\Utility\Utility;

class Form {
  public Mail $admin;

  /** @var AbstractFinisher[] */
  public array $finishers = [];

  public string $formId = '';

  public string $formName = '';

  public string $formValuesPrefix = '';

  /** @var AbstractLogger[] */
  public array $loggers = [];

  public string $predefinedForm = '';

  public int $redirectPage = 0;

  public string $requiredFields = '';

  public string $responseType = 'html';

  public int $step = 1;

  /** @var Step[] */
  public array $steps = [];

  public string $templateMailHtml = '';

  public string $templateMailText = '';

  public Mail $user;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings = []) {
    // Get flexform settings
    $this->admin = GeneralUtility::makeInstance(Mail::class, $settings['admin'] ?? []);
    $this->predefinedForm = strval($settings['predefinedForm'] ?? '');
    $this->redirectPage = intval($settings['redirectPage'] ?? 0);
    $this->requiredFields = strval($settings['requiredFields'] ?? '');
    $this->responseType = strval($settings['responseType'] ?? 'html');
    $this->user = GeneralUtility::makeInstance(Mail::class, $settings['user'] ?? []);

    if (!empty($this->predefinedForm)
      && isset($settings['predefinedForms'])
      && is_array($settings['predefinedForms'])
      && isset($settings['predefinedForms'][$this->predefinedForm])
      && is_array($settings['predefinedForms'][$this->predefinedForm])
    ) {
      // Get form settings
      $this->formId = strval($settings['predefinedForms'][$this->predefinedForm]['formId'] ?? '');
      $this->formName = strval($settings['predefinedForms'][$this->predefinedForm]['formName'] ?? '');
      $this->formValuesPrefix = strval($settings['predefinedForms'][$this->predefinedForm]['formValuesPrefix'] ?? '');
      $this->templateMailHtml = strval($settings['predefinedForms'][$this->predefinedForm]['templateMailHtml'] ?? '');
      $this->templateMailText = strval($settings['predefinedForms'][$this->predefinedForm]['templateMailText'] ?? '');

      // Get default form template if no step template is set
      $templateForm = strval($settings['predefinedForms'][$this->predefinedForm]['templateForm'] ?? '');

      $utility = GeneralUtility::makeInstance(Utility::class);

      // Get form logger
      foreach ($settings['predefinedForms'][$this->predefinedForm]['loggers'] ?? [] as $logger) {
        /** @var AbstractLogger $loggerModel */
        $loggerModel = GeneralUtility::makeInstance($utility::classString(strval($logger['model'] ?? 'Typoheads\\Formhandler\\Domain\\Model\\Config\\Logger\\Database'), 'Typoheads\\Formhandler\\Domain\\Model\\Config\\Logger\\'), $settings['user'] ?? []);

        $this->loggers[] = $loggerModel;
      }

      // Get form steps
      foreach ($settings['predefinedForms'][$this->predefinedForm]['steps'] ?? [] as $stepKey => $step) {
        if (empty($step) || !is_array($step)) {
          continue;
        }

        $this->steps[intval($stepKey)] = GeneralUtility::makeInstance(Step::class, $step, $templateForm);
      }
      if (0 == count($this->steps)) {
        $this->steps[1] = GeneralUtility::makeInstance(Step::class, [], $templateForm);
      }

      foreach ($settings['predefinedForms'][$this->predefinedForm]['finishers'] ?? [] as $finisher) {
        if (empty($finisher['model'])) {
          continue;
        }

        /** @var AbstractFinisher $finisherModel */
        $finisherModel = GeneralUtility::makeInstance($utility::classString(strval($finisher['model']), 'Typoheads\\Formhandler\\Domain\\Model\\Config\\Finisher\\'), $finisher['config'] ?? []);

        $this->finishers[] = $finisherModel;
      }
    }
  }
}
