<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Debugger;

use Typoheads\Formhandler\Debugger\AbstractDebugger;

abstract class AbstractDebuggerModel {
  /** @var class-string<AbstractDebugger> */
  public string $class;

  /**
   * @param array<string, mixed> $settings
   */
  abstract public function __construct(array $settings);
}
