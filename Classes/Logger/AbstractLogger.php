<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Logger;

use TYPO3\CMS\Core\SingletonInterface;
use Typoheads\Formhandler\Domain\Model\Config\FormModel;
use Typoheads\Formhandler\Domain\Model\Config\Logger\AbstractLoggerModel;

abstract class AbstractLogger implements SingletonInterface {
  abstract public function process(FormModel &$formConfig, AbstractLoggerModel &$loggerConfig): void;
}
