<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\Validator\ErrorCheck;

use Typoheads\Formhandler\Domain\Model\Config\FormModel;
use Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck\AbstractErrorCheckModel;
use Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck\NotEqualsFieldModel;

class NotEqualsField extends AbstractErrorCheck {
  public function isValid(FormModel &$formConfig, AbstractErrorCheckModel &$notEqualsFieldErrorCheckConfig, mixed $value): bool {
    if (!$notEqualsFieldErrorCheckConfig instanceof NotEqualsFieldModel) {
      return false;
    }

    $fieldValue = $formConfig->formValues;
    foreach ($notEqualsFieldErrorCheckConfig->field as $fieldPathKey) {
      if (!is_array($fieldValue) || !isset($fieldValue[$fieldPathKey])) {
        return false;
      }

      $fieldValue = $fieldValue[$fieldPathKey];
    }

    if ($value != $fieldValue) {
      return true;
    }

    return false;
  }
}
