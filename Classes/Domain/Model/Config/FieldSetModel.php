<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config;

class FieldSetModel {
  public function __construct(
    public readonly string $name,
    public readonly string $value,
    public readonly string $id = '',
  ) {
  }
}
