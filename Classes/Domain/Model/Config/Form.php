<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Typoheads\Formhandler\Domain\Model\Config\Finisher\AbstractFinisher;
use Typoheads\Formhandler\Domain\Model\Config\Logger\AbstractLogger;
use Typoheads\Formhandler\Domain\Model\Config\Validator\AbstractValidator;
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

  public string $templateForm = '';

  public string $templateMailHtml = '';

  public string $templateMailText = '';

  public Mail $user;

  /** @var AbstractValidator[] */
  public array $validators = [];

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings = []) {
    $utility = GeneralUtility::makeInstance(Utility::class);

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
      $this->formId = strval($settings['predefinedForms'][$this->predefinedForm]['formId'] ?? '');
      $this->formName = strval($settings['predefinedForms'][$this->predefinedForm]['formName'] ?? '');
      $this->formValuesPrefix = strval($settings['predefinedForms'][$this->predefinedForm]['formValuesPrefix'] ?? '');
      $this->templateForm = strval($settings['predefinedForms'][$this->predefinedForm]['templateForm'] ?? '');
      $this->templateMailHtml = strval($settings['predefinedForms'][$this->predefinedForm]['templateMailHtml'] ?? '');
      $this->templateMailText = strval($settings['predefinedForms'][$this->predefinedForm]['templateMailText'] ?? '');

      foreach ($settings['predefinedForms'][$this->predefinedForm]['loggers'] ?? [] as $logger) {
        /** @var AbstractLogger $loggerModel */
        $loggerModel = GeneralUtility::makeInstance($utility::classString(strval($logger['model'] ?? 'Typoheads\\Formhandler\\Domain\\Model\\Config\\Logger\\Database'), 'Typoheads\\Formhandler\\Domain\\Model\\Config\\Logger\\'), $settings['user'] ?? []);

        $this->loggers[] = $loggerModel;
      }
      foreach ($settings['predefinedForms'][$this->predefinedForm]['validators'] ?? [] as $validator) {
        /** @var AbstractValidator $validatorModel */
        $validatorModel = GeneralUtility::makeInstance($utility::classString(strval($validator['model'] ?? 'Typoheads\\Formhandler\\Domain\Model\\Config\\Validator\\DefaultValidator'), 'Typoheads\\Formhandler\\Domain\\Model\\Config\\Validator\\'), $validator['config'] ?? []);

        $this->validators[] = $validatorModel;
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
