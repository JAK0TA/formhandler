<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck;

use Typoheads\Formhandler\Validator\ErrorCheck\FileRequired;

/** Documentation:Start:ErrorChecks/FileUpload/FileRequired.rst.
 *
 *.. _filerequired:
 *
 *============
 *FileRequired
 *============
 *
 *Checks if a file has been uploaded from this field..
 *
 *..  code-block:: typoscript
 *
 *    Example Code:
 *
 *    validators {
 *      DefaultValidator {
 *        model = DefaultValidator
 *        config {
 *          fields {
 *            image.errorChecks {
 *              fileRequired {
 *                model = FileRequired
 *              }
 *            }
 *          }
 *        }
 *      }
 *    }
 *
 *.. toctree::
 *   :maxdepth: 2
 *   :hidden:
 *
 *Documentation:End
 */
class FileRequiredModel extends AbstractErrorCheckModel {
  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'FileRequired';
    $this->isRequired = true;
    $settings = $settings;
  }

  public function class(): string {
    return FileRequired::class;
  }
}
