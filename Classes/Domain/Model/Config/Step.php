<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Typoheads\Formhandler\Domain\Model\Config\Validator\AbstractValidator;
use Typoheads\Formhandler\Utility\Utility;

class Step {
  public string $templateForm = '';

  /** @var AbstractValidator[] */
  public array $validators = [];

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings = [], string $templateForm) {
    $utility = GeneralUtility::makeInstance(Utility::class);

    $this->templateForm = strval($settings['templateForm'] ?? $templateForm);

    foreach ($settings['validators'] ?? [] as $validator) {
      /** @var AbstractValidator $validatorModel */
      $validatorModel = GeneralUtility::makeInstance($utility::classString(strval($validator['model'] ?? 'Typoheads\\Formhandler\\Domain\Model\\Config\\Validator\\DefaultValidator'), 'Typoheads\\Formhandler\\Domain\\Model\\Config\\Validator\\'), $validator['config'] ?? []);

      $this->validators[] = $validatorModel;
    }
  }
}
