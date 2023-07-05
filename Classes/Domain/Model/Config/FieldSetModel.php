<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

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
