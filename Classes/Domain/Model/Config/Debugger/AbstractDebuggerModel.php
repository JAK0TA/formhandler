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
