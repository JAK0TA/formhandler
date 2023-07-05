<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\Domain\Model\Config\Validator\Field;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Typoheads\Formhandler\Domain\Model\Config\Validator\AbstractValidatorModel;
use Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck\AbstractErrorCheckModel;
use Typoheads\Formhandler\Utility\Utility;

class FieldModel {
  /** @var AbstractErrorCheckModel[] */
  public readonly array $errorChecks;

  public readonly bool $fieldArray;

  /** @var FieldModel[] */
  public readonly array $fields;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(
    public readonly string $name,
    private readonly AbstractValidatorModel $validator,
    array $settings,
  ) {
    $fields = [];
    if (isset($settings['fields']) && is_array($settings['fields'])) {
      foreach ($settings['fields'] as $subFieldName => $subFieldSettings) {
        /** @var FieldModel $fieldModel */
        $fieldModel = GeneralUtility::makeInstance(FieldModel::class, $subFieldName, $validator, $subFieldSettings);
        $fields[] = $fieldModel;
      }
    }
    $this->fields = $fields;

    $this->fieldArray = filter_var($settings['fieldArray'] ?? false, FILTER_VALIDATE_BOOLEAN);

    if (!isset($settings['errorChecks']) || !is_array($settings['errorChecks'])) {
      $this->errorChecks = [];

      return;
    }

    $utility = GeneralUtility::makeInstance(Utility::class);
    $errorChecks = [];
    foreach ($settings['errorChecks'] as $errorCheck) {
      if (!is_array($errorCheck) || empty($errorCheck['model'])) {
        continue;
      }

      /** @var AbstractErrorCheckModel $errorCheckModel */
      $errorCheckModel = GeneralUtility::makeInstance($utility->classString(strval($errorCheck['model']), 'Typoheads\\Formhandler\\Domain\\Model\\Config\\Validator\\ErrorCheck\\'), (array) $errorCheck);

      if (!empty($validator->restrictErrorChecks()) && !in_array($errorCheckModel->class(), $this->validator->restrictErrorChecks())) {
        continue;
      }

      $errorChecks[] = $errorCheckModel;
    }

    $this->errorChecks = $errorChecks;
  }
}
