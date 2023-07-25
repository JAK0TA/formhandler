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

class FormUploadFile {
  public bool $error = false;

  public string $name = '';

  public int $size = 0;

  public string $temp = '';

  public string $type = '';
}
