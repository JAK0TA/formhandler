<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config;

use Typoheads\Formhandler\Definitions\FormhandlerExtensionConfig;

class FieldSetModel {
  public readonly string $extensionKey;

  public function __construct(
    public readonly string $name,
    public readonly string $value,
    public readonly string $id = '',
  ) {
    $this->extensionKey = FormhandlerExtensionConfig::EXTENSION_KEY;
  }
}
