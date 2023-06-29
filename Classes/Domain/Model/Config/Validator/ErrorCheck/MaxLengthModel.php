<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck;

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
    // TODO: FIX ME
    // @phpstan-ignore-next-line
    return '\\Typoheads\\Formhandler\\Validator\\ErrorCheck\\MaxLength';
  }
}
