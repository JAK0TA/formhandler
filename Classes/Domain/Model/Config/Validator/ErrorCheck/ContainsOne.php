<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck;

class ContainsOne extends AbstractErrorCheck {
  public string $words = '';

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(
    protected readonly array $settings = []
  ) {
    $this->class = '\\Typoheads\\Formhandler\\Validator\\ErrorCheck\\ContainsOne';
    $this->name = 'ContainsOne';
    $this->words = strval($this->settings['words'] ?? '');
  }
}
