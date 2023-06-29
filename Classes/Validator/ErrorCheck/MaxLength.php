<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Validator\ErrorCheck;

use Typoheads\Formhandler\Domain\Model\Config\FormModel;
use Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck\AbstractErrorCheckModel;
use Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck\MaxLengthModel;

class MaxLength extends AbstractErrorCheck {
  public function isValid(FormModel &$formConfig, AbstractErrorCheckModel &$maxLengthErrorCheckConfig, mixed $value): bool {
    if (!$maxLengthErrorCheckConfig instanceof MaxLengthModel) {
      return false;
    }

    if (is_string($value)
        && mb_strlen(trim($value), 'utf-8') > 0
        && $maxLengthErrorCheckConfig->maxLength > 0
        && mb_strlen(trim($value), 'utf-8') > $maxLengthErrorCheckConfig->maxLength
    ) {
      return false;
    }

    return true;
  }
}
