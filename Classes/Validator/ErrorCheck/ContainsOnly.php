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
use Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck\ContainsOnlyModel;

class ContainsOnly extends AbstractErrorCheck {
  public function isValid(FormModel &$formConfig, AbstractErrorCheckModel &$containsOnlyErrorCheckConfig, mixed $value): bool {
    if (!$containsOnlyErrorCheckConfig instanceof ContainsOnlyModel) {
      return false;
    }

    $array = preg_split('//', strval($value), -1, PREG_SPLIT_NO_EMPTY);

    if (is_array($array)) {
      foreach ($array as $char) {
        if (!in_array(trim($char), $containsOnlyErrorCheckConfig->characters)) {
          return false;
        }
      }

      return true;
    }

    return false;
  }
}
