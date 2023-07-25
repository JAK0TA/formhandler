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
use Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck\IntegerModel;

class Integer extends AbstractErrorCheck {
  public function isValid(FormModel &$formConfig, AbstractErrorCheckModel &$errorCheckConfig, string $fieldNamePathBrackets, string $fieldNamePathDots, mixed $value): bool {
    if (!$errorCheckConfig instanceof IntegerModel) {
      return false;
    }

    if (false !== filter_var($value, FILTER_VALIDATE_INT)) {
      return true;
    }

    return false;
  }
}
