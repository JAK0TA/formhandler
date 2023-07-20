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
use Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck\ItemsBetweenModel;

class ItemsBetween extends AbstractErrorCheck {
  public function isValid(FormModel &$formConfig, AbstractErrorCheckModel &$errorCheckConfig, mixed $value): bool {
    if (!$errorCheckConfig instanceof ItemsBetweenModel) {
      return false;
    }

    if (is_array($value)) {
      $valueCount = count($value);
      if ($errorCheckConfig->itemsMax > 0
        && $valueCount <= $errorCheckConfig->itemsMax
        && $errorCheckConfig->itemsMin > 0
        && $valueCount >= $errorCheckConfig->itemsMin
      ) {
        return true;
      }
    }

    return false;
  }
}