<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\Domain\Model\Config\Validator;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Typoheads\Formhandler\Domain\Model\Config\FormModel;
use Typoheads\Formhandler\Domain\Model\Config\Validator\Field\FieldModel;
use Typoheads\Formhandler\Utility\Utility;
use Typoheads\Formhandler\Validator\DefaultValidator;

/** Documentation:Start:Validators/DefaultValidator.rst.
 *
 *.. _defaultvalidator:
 *
 *================
 *DefaultValidator
 *================
 *
 *
 *
 *
 *Documentation:End
 */
class DefaultValidatorModel extends AbstractValidatorModel {
  public readonly int $messageLimit;

  /** @var array<string, int> */
  public readonly array $messageLimits;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(FormModel &$formConfig, array $settings) {
    $utility = GeneralUtility::makeInstance(Utility::class);

    foreach (GeneralUtility::trimExplode(',', strval($settings['restrictErrorChecks'] ?? ''), true) as $restrictErrorCheck) {
      $this->restrictErrorChecks[] = $utility->classString($restrictErrorCheck, '\\Typoheads\\Formhandler\\Validator\\ErrorCheck\\');
    }

    if (isset($settings['disableErrorCheckFields'])) {
      if (is_string($settings['disableErrorCheckFields'])) {
        foreach (GeneralUtility::trimExplode(',', $settings['disableErrorCheckFields'], true) as $field) {
          $formConfig->disableErrorCheckFields[strval($field)] = [];
        }
      } elseif (is_array($settings['disableErrorCheckFields'])) {
        foreach ($settings['disableErrorCheckFields'] as $field => $errorChecks) {
          if (empty($errorChecks)) {
            $formConfig->disableErrorCheckFields[strval($field)] = [];

            continue;
          }
          foreach (GeneralUtility::trimExplode(',', $errorChecks, true) as $errorCheck) {
            $formConfig->disableErrorCheckFields[strval($field)][] = $utility->classString($errorCheck, '\\Typoheads\\Formhandler\\Validator\\ErrorCheck\\');
          }
        }
      }
    }

    $this->messageLimit = intval($settings['messageLimit'] ?? 1);

    if (isset($settings['messageLimits']) && is_array($settings['messageLimits'])) {
      $this->messageLimits = $this->messageLimits($settings['messageLimits']);
    } else {
      $this->messageLimits = [];
    }

    if (isset($settings['fields']) && is_array($settings['fields'])) {
      foreach ($settings['fields'] as $fieldName => $fieldSettings) {
        /** @var FieldModel $fieldModel */
        $fieldModel = GeneralUtility::makeInstance(FieldModel::class, $fieldName, $this, $fieldSettings);

        $this->fields[] = $fieldModel;
      }
    }
  }

  public function class(): string {
    return DefaultValidator::class;
  }

  /**
   * @param array<string, mixed> $messageLimits
   *
   * @return array<string, int>
   */
  private function messageLimits(array $messageLimits, string $fieldNamePath = ''): array {
    $fieldNamePath = empty($fieldNamePath) ? $fieldNamePath : $fieldNamePath.'.';
    $messageLimitFields = [];
    foreach ($messageLimits as $field => $messageLimit) {
      if (is_array($messageLimit)) {
        $messageLimitFields = $this->messageLimits($messageLimit, $fieldNamePath.$field);
      } else {
        $messageLimitFields[$fieldNamePath.$field] = intval($messageLimit ?? 1);
      }
    }

    return $messageLimitFields;
  }
}
