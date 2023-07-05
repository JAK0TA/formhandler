<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\Domain\Model\Config\Debugger;

use Typoheads\Formhandler\Debugger\AbstractDebugger;

/** Documentation:Start:TocTree:Debuggers/Index.rst.
 *
 *.. _debuggers:
 *
 *=========
 *Debuggers
 *=========
 *
 *You can enter as many debuggers as you like. Each entry requires a model name of the debugger. Optionally you can enter a specific configuration for the debugger in the config section.
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **TypoScript Path**
 *     - plugin.tx_formhandler_form.settings.predefinedForms.FormName
 *
 *:ref:`PrintToScreenDebugger`
 *  Will print out the debug messages to screen.
 *
 *:ref:`VarDumpDebugger`
 *  Will print out the debug messages to screen as VarDump.
 *
 *.. toctree::
 *   :maxdepth: 2
 *   :hidden:
 *
 *   PrintToScreenDebugger
 *   VarDumpDebugger
 *
 *Documentation:End
 */
abstract class AbstractDebuggerModel {
  /**
   * @param array<string, mixed> $config
   */
  abstract public function __construct(array $config);

  /**
   * @return class-string<AbstractDebugger>
   */
  abstract public function class(): string;
}
