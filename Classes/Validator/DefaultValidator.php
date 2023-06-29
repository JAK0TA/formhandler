<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Validator;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Typoheads\Formhandler\Domain\Model\Config\FormModel;
use Typoheads\Formhandler\Domain\Model\Config\Validator\AbstractValidatorModel;
use Typoheads\Formhandler\Domain\Model\Config\Validator\DefaultValidatorModel;
use Typoheads\Formhandler\Domain\Model\Config\Validator\Field\FieldModel;

class DefaultValidator extends AbstractValidator {
  public function process(FormModel &$formConfig, AbstractValidatorModel &$validatorConfig): bool {
    if (!$validatorConfig instanceof DefaultValidatorModel) {
      return false;
    }

    return $this->checkFields($formConfig, $formConfig->formValues[$formConfig->step] ?? [], $validatorConfig->fields);
  }

  /**
   * @param FieldModel[] $fields
   */
  private function checkFields(FormModel $formConfig, mixed $formValues, array $fields): bool {
    $isValid = true;

    foreach ($fields as $field) {
      $formValue = null;
      if (is_array($formValues)) {
        $formValue = $formValues[$field->name] ?? null;
      }
      foreach ($field->errorChecks as $errorCheck) {
        if (GeneralUtility::makeInstance($errorCheck->class())->hasError($formConfig, $errorCheck, $formValue ?? '')) {
          $isValid = false;
          // TODO: Prepare error message
        }
      }
      if (!empty($field->fields)) {
        $isValid = $this->checkFields($formConfig, $formValue ?? [], $field->fields);
      }
    }

    return $isValid;
  }
}
