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
