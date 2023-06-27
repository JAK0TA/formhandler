<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Logger;

use Typoheads\Formhandler\Logger\AbstractLogger;

abstract class AbstractLoggerModel {
  /** @var class-string<AbstractLogger> */
  public string $class;

  /**
   * @param array<string, mixed> $settings
   */
  abstract public function __construct(array $settings);
}
