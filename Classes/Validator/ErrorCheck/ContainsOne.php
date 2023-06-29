<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Validator\ErrorCheck;

use Typoheads\Formhandler\Domain\Model\Config\FormModel;
use Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck\AbstractErrorCheckModel;

class ContainsOne extends AbstractErrorCheck {
  public function hasError(FormModel &$formConfig, AbstractErrorCheckModel &$containsOneErrorCheckConfig, mixed $value): bool {
    return false;
  }
}
