<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck;

class EmailModel extends AbstractErrorCheckModel {
  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(
    protected readonly array $settings
  ) {
    $this->class = '\\Typoheads\\Formhandler\\Validator\\ErrorCheck\\Email';
    $this->name = 'Email';
  }
}
