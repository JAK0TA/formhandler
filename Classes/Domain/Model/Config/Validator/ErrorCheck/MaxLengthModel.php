<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck;

use Typoheads\Formhandler\Validator\ErrorCheck\MaxLength;

class MaxLengthModel extends AbstractErrorCheckModel {
  public readonly int $maxLength;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'MaxLength';
    $this->maxLength = intval($settings['maxLength'] ?? 0);
  }

  public function class(): string {
    return MaxLength::class;
  }
}
