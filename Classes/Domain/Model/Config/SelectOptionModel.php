<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config;

class SelectOptionModel {
  public function __construct(
    public readonly string $value,
    public readonly string $title,
  ) {
  }
}
