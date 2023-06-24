<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Logger;

abstract class AbstractLogger {
  public string $class = '';

  /**
   * @param array<string, mixed> $settings
   */
  abstract public function __construct(array $settings = []);
}
