<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Debugger;

use TYPO3\CMS\Core\SingletonInterface;
use Typoheads\Formhandler\Domain\Model\Config\Debugger\AbstractDebuggerModel;
use Typoheads\Formhandler\Domain\Model\Config\FormModel;

abstract class AbstractDebugger implements SingletonInterface {
  abstract public function process(FormModel &$formConfig, AbstractDebuggerModel &$debuggerConfig): void;
}
