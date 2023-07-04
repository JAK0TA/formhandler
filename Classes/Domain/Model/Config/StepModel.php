<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Typoheads\Formhandler\Domain\Model\Config\Validator\AbstractValidatorModel;
use Typoheads\Formhandler\Utility\Utility;

class StepModel {
  /** @var AbstractValidatorModel[] */
  public readonly array $validators;

  private readonly string $templateForm;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(FormModel &$formConfig, array $settings, string $templateForm) {
    $utility = GeneralUtility::makeInstance(Utility::class);

    $this->templateForm = strval($settings['templateForm'] ?? $templateForm);

    if (!is_array($settings['validators'] ?? false)) {
      $this->validators = [];

      return;
    }

    $validators = [];
    foreach ($settings['validators'] as $validator) {
      /** @var AbstractValidatorModel $validatorModel */
      $validatorModel = GeneralUtility::makeInstance($utility::classString(strval($validator['model'] ?? 'Typoheads\\Formhandler\\Domain\Model\\Config\\Validator\\DefaultValidator'), 'Typoheads\\Formhandler\\Domain\\Model\\Config\\Validator\\'), $formConfig, $validator['config'] ?? []);

      $validators[] = $validatorModel;
    }

    $this->validators = $validators;
  }

  public function templateForm(): string {
    return $this->templateForm;
  }
}
