<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck;

use Typoheads\Formhandler\Validator\ErrorCheck\Required;

class RequiredModel extends AbstractErrorCheckModel {
  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'Required';
    if (isset($settings['FIXME'])) {
    }
  }

  public function class(): string {
    return Required::class;
  }
}
