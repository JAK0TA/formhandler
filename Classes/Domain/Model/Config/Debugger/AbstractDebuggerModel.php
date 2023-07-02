<?php

declare(strict_types=1);

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
 * You can enter as many debuggers as you like. Each entry requires a model name of the debugger. Optionally you can enter a specific configuration for the debugger in the config section.
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
 *..  code-block:: typoscript
 *
 *    Example Code:
 *
 *    plugin.tx_formhandler_form.settings.predefinedForms.devExample {
 *      debuggers {
 *        VarDumpDebugger {
 *          model = VarDumpDebuggerModel
 *          config {
 *            active = true
 *            maxDepth = 20
 *          }
 *        }
 *      }
 *    }
 *
 *.. toctree::
 *   :maxdepth: 2
 *   :hidden:
 *
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
