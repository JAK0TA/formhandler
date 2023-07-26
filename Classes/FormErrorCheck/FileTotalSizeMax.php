<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\FormErrorCheck;

use Typoheads\Formhandler\Domain\Model\Config\FormModel;

class FileTotalSizeMax {
  public function isValid(FormModel &$formConfig): bool {
    if (false === $formConfig->fileUpload->totalSizeMax) {
      return true;
    }

    $fileTotalSize = 0;
    foreach ($formConfig->formUploads->files as $fieldNamePathBrackets) {
      foreach ($fieldNamePathBrackets as $file) {
        $fileTotalSize += $file->size;
      }
    }

    return $fileTotalSize <= $formConfig->fileUpload->totalSizeMax;
  }
}
