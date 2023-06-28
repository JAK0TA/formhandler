<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck;

class MaxLengthModel extends AbstractErrorCheckModel {
  public int $maxLength = 0;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(
    protected readonly array $settings
  ) {
    $this->maxLength = intval($this->settings['maxLength'] ?? 0);
  }

  public function class(): string {
    // TODO: FIX ME
    // @phpstan-ignore-next-line
    return '\\Typoheads\\Formhandler\\Validator\\ErrorCheck\\MaxLength';
  }

  public function name(): string {
    return 'MaxLength';
  }
}
