<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Debugger;

use Typoheads\Formhandler\Debugger\AbstractDebugger;

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
