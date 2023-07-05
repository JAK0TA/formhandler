<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\Validator;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Typoheads\Formhandler\Domain\Model\Config\FormModel;
use Typoheads\Formhandler\Domain\Model\Config\Validator\AbstractValidatorModel;
use Typoheads\Formhandler\Domain\Model\Config\Validator\DefaultValidatorModel;
use Typoheads\Formhandler\Domain\Model\Config\Validator\Field\FieldModel;

class DefaultValidator extends AbstractValidator {
  private DefaultValidatorModel $validatorConfig;

  public function process(FormModel &$formConfig, AbstractValidatorModel &$validatorConfig): bool {
    if (!$validatorConfig instanceof DefaultValidatorModel) {
      return false;
    }
    $this->validatorConfig = $validatorConfig;

    return $this->checkFields($formConfig, $formConfig->formValues[$formConfig->step] ?? [], $validatorConfig->fields, (string) $formConfig->step, '['.$formConfig->step.']');
  }

  /**
   * @param FieldModel[] $fields
   */
  private function checkFields(FormModel &$formConfig, mixed $formValues, array $fields, string $fieldNameDots, string $fieldNameBrackets): bool {
    $isValid = true;

    foreach ($fields as $field) {
      $fieldNamePathDots = $fieldNameDots.'.'.$field->name;
      $fieldNamePathBrackets = $fieldNameBrackets.'['.$field->name.']';
      $formValue = null;
      if (is_array($formValues)) {
        $formValue = $formValues[$field->name] ?? null;
      }

      if (
        isset($formConfig->disableErrorCheckFields[$fieldNamePathDots])
        && empty($formConfig->disableErrorCheckFields[$fieldNamePathDots])
      ) {
        continue;
      }

      foreach ($field->errorChecks as $errorCheck) {
        if (
          !in_array($errorCheck->class(), $formConfig->disableErrorCheckFields[$fieldNamePathDots] ?? [])
          && !GeneralUtility::makeInstance($errorCheck->class())->isValid($formConfig, $errorCheck, $formValue ?? '')
        ) {
          $isValid = false;
          if (
            (
              intval($this->validatorConfig->messageLimits[$fieldNamePathDots] ?? 0) > 0
              && count($formConfig->fieldsErrors[$fieldNamePathBrackets] ?? []) >= intval($this->validatorConfig->messageLimits[$fieldNamePathDots])
            )
            || (
              0 == intval($this->validatorConfig->messageLimits[$fieldNamePathDots] ?? 0)
              && count($formConfig->fieldsErrors[$fieldNamePathBrackets] ?? []) >= $this->validatorConfig->messageLimit
            )
          ) {
            continue;
          }

          $formConfig->fieldsErrors[$fieldNamePathBrackets][] = $errorCheck->name;
        }
      }
      if (!empty($field->fields)) {
        $isValid = $this->checkFields($formConfig, $formValue ?? [], $field->fields, $fieldNamePathDots, $fieldNamePathBrackets);
      }
    }

    return $isValid;
  }
}
