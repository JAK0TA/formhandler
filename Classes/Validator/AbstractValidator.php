<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Validator;

use TYPO3\CMS\Core\SingletonInterface;
use Typoheads\Formhandler\Domain\Model\Config\FormModel;
use Typoheads\Formhandler\Domain\Model\Config\Validator\AbstractValidatorModel;

abstract class AbstractValidator implements SingletonInterface {
  abstract public function process(FormModel &$formConfig, AbstractValidatorModel &$validatorConfig): bool;
}
