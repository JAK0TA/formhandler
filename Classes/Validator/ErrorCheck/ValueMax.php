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
use Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck\ValueMaxModel;

class ValueMax extends AbstractErrorCheck {
  public function isValid(FormModel &$formConfig, AbstractErrorCheckModel &$valueMaxErrorCheckConfig, mixed $value): bool {
    if (!$valueMaxErrorCheckConfig instanceof ValueMaxModel) {
      return false;
    }

    $valueTemp = filter_var($value ?? 0, FILTER_VALIDATE_INT);
    if (false === $valueTemp) {
      $valueTemp = filter_var($value ?? 0, FILTER_VALIDATE_FLOAT) ?: 0;
    }

    if (
      $valueMaxErrorCheckConfig->valueMax > 0
      && $valueTemp <= $valueMaxErrorCheckConfig->valueMax
    ) {
      return true;
    }

    return false;
  }
}
