<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\Validator\ErrorCheck;

use Typoheads\Formhandler\Domain\Model\Config\FormModel;
use Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck\AbstractErrorCheckModel;
use Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck\FileTypesAllowedModel;

class FileTypesAllowed extends AbstractErrorCheck {
  public function isValid(FormModel &$formConfig, AbstractErrorCheckModel &$errorCheckConfig, string $fieldNamePathBrackets, string $fieldNamePathDots, mixed $value): bool {
    if (!$errorCheckConfig instanceof FileTypesAllowedModel) {
      return false;
    }

    if (empty($errorCheckConfig->fileTypes) || !isset($formConfig->formUploads->files[$fieldNamePathBrackets])) {
      return true;
    }

    $isValid = true;
    foreach ($formConfig->formUploads->files[$fieldNamePathBrackets] as $file) {
      foreach ($errorCheckConfig->fileTypes as $fileType) {
        if (str_starts_with($file->type, $fileType)) {
          continue 2;
        }
      }
      $file->error = true;
      $isValid = false;
    }

    return $isValid;
  }
}
