<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Validator\ErrorCheck;

use Typoheads\Formhandler\Domain\Model\Config\FormModel;
use Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck\AbstractErrorCheckModel;
use Typoheads\Formhandler\Utility\Utility;

class Email extends AbstractErrorCheck {
  public function isValid(FormModel &$formConfig, AbstractErrorCheckModel &$emailErrorCheckConfig, mixed $email): bool {
    if (is_string($email) && strlen($email) > 0) {
      return Utility::validEmail($email);
    }

    return false;
  }
}
