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
use Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck\MinLengthModel;

class MinLength extends AbstractErrorCheck {
  public function isValid(FormModel &$formConfig, AbstractErrorCheckModel &$minLengthErrorCheckConfig, mixed $value): bool {
    if (!$minLengthErrorCheckConfig instanceof MinLengthModel) {
      return false;
    }

    if (is_string($value)
        && $minLengthErrorCheckConfig->minLength > 0
        && mb_strlen(trim($value), 'utf-8') > $minLengthErrorCheckConfig->minLength
    ) {
      return true;
    }

    return false;
  }
}
