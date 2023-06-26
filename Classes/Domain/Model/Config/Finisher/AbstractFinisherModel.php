<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Finisher;

abstract class AbstractFinisherModel {
  public string $class = '';

  public bool $returns = false;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings = []) {
    $this->returns = boolval($settings['returns'] ?? false);
  }
}
