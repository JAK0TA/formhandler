<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Validator;

use Typoheads\Formhandler\Domain\Model\Config\FormModel;
use Typoheads\Formhandler\Domain\Model\Config\Validator\AbstractValidatorModel;
use Typoheads\Formhandler\Domain\Model\Config\Validator\DefaultValidatorModel;

class DefaultValidator extends AbstractValidator {
  public function process(FormModel &$formConfig, AbstractValidatorModel &$validatorConfig): bool {
    if (!$validatorConfig instanceof DefaultValidatorModel) {
      return false;
    }

    return true;
  }
}
