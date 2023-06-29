<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Validator\ErrorCheck;

use Typoheads\Formhandler\Domain\Model\Config\FormModel;
use Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck\AbstractErrorCheckModel;

class Required extends AbstractErrorCheck {
  public function process(FormModel &$formConfig, AbstractErrorCheckModel &$requiredErrorCheckConfig, mixed $value): bool {
    return true;
  }
}
