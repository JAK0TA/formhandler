<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck;

class RequiredModel extends AbstractErrorCheckModel {
  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(
    protected readonly array $settings
  ) {
  }

  public function class(): string {
    // TODO: FIX ME
    // @phpstan-ignore-next-line
    return '\\Typoheads\\Formhandler\\Validator\\ErrorCheck\\Required';
  }

  public function name(): string {
    return 'Required';
  }
}
