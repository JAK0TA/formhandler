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
use Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck\ItemsMaxModel;

class ItemsMax extends AbstractErrorCheck {
  public function isValid(FormModel &$formConfig, AbstractErrorCheckModel &$itemsMaxErrorCheckConfig, mixed $value): bool {
    if (!$itemsMaxErrorCheckConfig instanceof ItemsMaxModel) {
      return false;
    }

    if (is_array($value)
      && $itemsMaxErrorCheckConfig->itemsMax > 0
      && count($value) <= $itemsMaxErrorCheckConfig->itemsMax
    ) {
      return true;
    }

    return false;
  }
}
