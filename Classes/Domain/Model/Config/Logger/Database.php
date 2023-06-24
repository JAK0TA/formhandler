<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Logger;

class Database extends AbstractLogger {
  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(
    protected readonly array $settings = []
  ) {
    $this->class = '\\Typoheads\\Formhandler\\Logger\\Database';
  }
}
