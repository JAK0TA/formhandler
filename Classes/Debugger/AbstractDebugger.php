<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\Debugger;

use TYPO3\CMS\Core\SingletonInterface;
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
   * @param array<string, array<int, array{message: string, severity: int, data: array<int|string, mixed>|object|string}>> $debugLog
   */
  abstract public function processDebugLog(
    array $debugLog,
  ): ?string;
}
