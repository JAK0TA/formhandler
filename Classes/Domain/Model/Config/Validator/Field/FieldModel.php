<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Validator\Field;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Typoheads\Formhandler\Domain\Model\Config\Validator\AbstractValidatorModel;
use Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck\AbstractErrorCheckModel;
use Typoheads\Formhandler\Utility\Utility;

class FieldModel {
  /** @var AbstractErrorCheckModel[] */
  public array $errorChecks = [];

  public bool $fieldArray = false;

  /** @var FieldModel[] */
  public array $fields = [];

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(
    public string $name,
    private readonly AbstractValidatorModel $validator,
    array $settings,
  ) {
    if (isset($settings['fields']) && is_array($settings['fields'])) {
      foreach ($settings['fields'] as $fieldName => $fieldSettings) {
        /** @var FieldModel $fieldModel */
        $fieldModel = GeneralUtility::makeInstance(FieldModel::class, $fieldName, $validator, $fieldSettings);

        $this->fields[] = $fieldModel;
      }
    }

    $this->fieldArray = boolval($settings['fieldArray'] ?? false);

    if (!isset($settings['errorChecks']) || !is_array($settings['errorChecks'])) {
      return;
    }
    if (isset($this->validator->disableErrorCheckFields[$this->name]) && 0 == count($this->validator->disableErrorCheckFields[$this->name])) {
      return;
    }

    $utility = GeneralUtility::makeInstance(Utility::class);

    foreach ($settings['errorChecks'] as $errorCheck) {
      if (!is_array($errorCheck) || empty($errorCheck['model'])) {
        continue;
      }

      /** @var AbstractErrorCheckModel $errorCheckModel */
      $errorCheckModel = GeneralUtility::makeInstance($utility->classString(strval($errorCheck['model']), 'Typoheads\\Formhandler\\Domain\\Model\\Config\\Validator\\ErrorCheck\\'), (array) $errorCheck);
      if (isset($this->validator->disableErrorCheckFields[$fieldName]) && in_array($errorCheckModel->class, $this->validator->disableErrorCheckFields[$fieldName])) {
        continue;
      }

      if (!empty($this->validator->restrictErrorChecks) && !in_array($errorCheckModel->class, $this->validator->restrictErrorChecks)) {
        continue;
      }
      $this->errorChecks[] = $errorCheckModel;
    }
  }
}
