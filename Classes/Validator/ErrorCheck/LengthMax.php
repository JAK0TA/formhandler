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
use Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck\LengthMaxModel;

class LengthMax extends AbstractErrorCheck {
  public function isValid(FormModel &$formConfig, AbstractErrorCheckModel &$lengthMaxErrorCheckConfig, mixed $value): bool {
    if (!$lengthMaxErrorCheckConfig instanceof LengthMaxModel) {
      return false;
    }

    if (is_string($value)
        && mb_strlen(trim($value), 'utf-8') > 0
        && $lengthMaxErrorCheckConfig->lengthMax > 0
        && mb_strlen(trim($value), 'utf-8') <= $lengthMaxErrorCheckConfig->lengthMax
    ) {
      return true;
    }

    return false;
  }
}
