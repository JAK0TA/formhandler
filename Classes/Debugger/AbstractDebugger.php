<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Debugger;

use TYPO3\CMS\Core\SingletonInterface;
use Typoheads\Formhandler\Definitions\Severity;
use Typoheads\Formhandler\Domain\Model\Config\Debugger\AbstractDebuggerModel;
use Typoheads\Formhandler\Domain\Model\Config\FormModel;

abstract class AbstractDebugger implements SingletonInterface {
  protected AbstractDebuggerModel $debuggerConfig;

  protected FormModel $formConfig;

  public function init(
    FormModel &$formConfig,
    AbstractDebuggerModel &$debuggerConfig,
  ): AbstractDebugger {
    $this->formConfig = $formConfig;
    $this->debuggerConfig = $debuggerConfig;

    return $this;
  }

  /**
   * @param array<string, array<int, array{message: string, severity: Severity, data: array<int|string, mixed>|object|string}>> $debugLog
   */
  abstract public function processDebugLog(
    array $debugLog,
  ): void;
}
