<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck;

class ContainsOneModel extends AbstractErrorCheckModel {
  public string $words = '';

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(
    protected readonly array $settings
  ) {
    $this->words = strval($this->settings['words'] ?? '');
  }

  public function class(): string {
    // TODO: FIX ME
    // @phpstan-ignore-next-line
    return '\\Typoheads\\Formhandler\\Validator\\ErrorCheck\\ContainsOne';
  }

  public function name(): string {
    return 'ContainsOne';
  }
}
