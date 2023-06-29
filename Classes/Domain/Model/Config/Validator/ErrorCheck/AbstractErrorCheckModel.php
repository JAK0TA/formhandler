<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck;

use Typoheads\Formhandler\Validator\ErrorCheck\AbstractErrorCheck;

abstract class AbstractErrorCheckModel {
  public string $name;

  /**
   * @param array<string, mixed> $settings
   */
  abstract public function __construct(array $settings);

  /**
   * @return class-string<AbstractErrorCheck>
   */
  abstract public function class(): string;
}
