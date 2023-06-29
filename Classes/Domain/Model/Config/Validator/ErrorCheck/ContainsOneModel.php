<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck;

use Typoheads\Formhandler\Validator\ErrorCheck\ContainsOne;

class ContainsOneModel extends AbstractErrorCheckModel {
  public readonly string $words;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'ContainsOne';
    $this->words = strval($settings['words'] ?? '');
  }

  public function class(): string {
    return ContainsOne::class;
  }
}
