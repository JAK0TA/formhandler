<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck;

class MaxLength extends AbstractErrorCheck {
  public int $maxLength = 0;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(
    protected readonly array $settings = []
  ) {
    $this->class = '\\Typoheads\\Formhandler\\Validator\\ErrorCheck\\MaxLength';
    $this->name = 'MaxLength';
    $this->maxLength = intval($this->settings['maxLength'] ?? 0);
  }
}
