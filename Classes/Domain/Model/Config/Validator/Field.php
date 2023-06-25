<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Validator;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck\AbstractErrorCheck;
use Typoheads\Formhandler\Utility\Utility;

class Field {
  /** @var AbstractErrorCheck[] */
  public array $errorChecks = [];

  public bool $fieldArray = false;

  /** @var Field[] */
  public array $fields = [];

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(
    public string $name,
    private readonly AbstractValidator $validator,
    array $settings = [],
  ) {
    if (isset($settings['fields']) && is_array($settings['fields'])) {
      foreach ($settings['fields'] as $fieldName => $fieldSettings) {
        /** @var Field $fieldModel */
        $fieldModel = GeneralUtility::makeInstance(Field::class, $fieldName, $validator, $fieldSettings);

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

      /** @var AbstractErrorCheck $errorCheckModel */
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
