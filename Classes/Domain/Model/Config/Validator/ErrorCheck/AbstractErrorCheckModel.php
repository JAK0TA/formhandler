<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck;

abstract class AbstractErrorCheckModel {
  public string $class = '';

  public string $name = '';

  /**
   * @param array<string, mixed> $settings
   */
  abstract public function __construct(array $settings);
}
