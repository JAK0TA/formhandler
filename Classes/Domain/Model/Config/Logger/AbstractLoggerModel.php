<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Logger;

use Typoheads\Formhandler\Logger\AbstractLogger;

abstract class AbstractLoggerModel {
  /**
   * @param array<string, mixed> $settings
   */
  abstract public function __construct(array $settings);

  /**
   * @return class-string<AbstractLogger>
   */
  abstract public function class(): string;
}
