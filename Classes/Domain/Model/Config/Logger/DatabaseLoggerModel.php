<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Logger;

use Typoheads\Formhandler\Logger\DatabaseLogger;

class DatabaseLoggerModel extends AbstractLoggerModel {
  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->class = DatabaseLogger::class;
    if (isset($settings['FIXME'])) {
    }
  }
}
