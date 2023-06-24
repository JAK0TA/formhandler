<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Validator;

abstract class AbstractValidator {
  public string $class = '';

  /**
   * @param array<string, mixed> $settings
   */
  abstract public function __construct(array $settings = []);
}
