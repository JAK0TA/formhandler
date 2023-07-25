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
use Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck\AgeMinModel;

class AgeMin extends AbstractErrorCheck {
  public function isValid(FormModel &$formConfig, AbstractErrorCheckModel &$errorCheckConfig, string $fieldNamePathBrackets, string $fieldNamePathDots, mixed $value): bool {
    if (!$errorCheckConfig instanceof AgeMinModel) {
      return false;
    }

    $date = \DateTime::createFromFormat('Y-m-d', strval($value ?? ''));
    if (false === $date) {
      return false;
    }

    if ($date->add(new \DateInterval('P'.$errorCheckConfig->ageMin.'Y')) >= new \DateTime('today midnight')) {
      return true;
    }

    return false;
  }
}
