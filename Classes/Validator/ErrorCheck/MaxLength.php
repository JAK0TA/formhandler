<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Validator\ErrorCheck;

use Typoheads\Formhandler\Domain\Model\Config\FormModel;
use Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck\AbstractErrorCheckModel;

class MaxLength extends AbstractErrorCheck {
  public function hasError(FormModel &$formConfig, AbstractErrorCheckModel &$maxLengthErrorCheckConfig, mixed $value): bool {
    return false;
  }
}
