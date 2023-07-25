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

use Typoheads\Formhandler\Validator\ErrorCheck\FileCountMax;

/** Documentation:Start:ErrorChecks/FileUpload/FileCountMax.rst.
 *
 *.. _filecountmax:
 *
 *============
 *FileCountMax
 *============
 *
 *Checks if the files uploaded from a field are less than or equal the configured value.
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
 *              fileCountMax {
 *                model = FileCountMax
 *                fileCountMax = 3
 *              }
 *            }
 *          }
 *        }
 *      }
 *    }
 *
 ***Properties**
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **fileCountMax**
 *     - Sets the max amount of files a field can upload.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - Integer
 *   * - *Default*
 *     - 0
 *
 *.. toctree::
 *   :maxdepth: 2
 *   :hidden:
 *
 *Documentation:End
 */
class FileCountMaxModel extends AbstractErrorCheckModel {
  public readonly int $fileCountMax;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'FileCountMax';
    $this->fileCountMax = filter_var($settings['fileCountMax'] ?? 0, FILTER_VALIDATE_INT) ?: 0;
  }

  public function class(): string {
    return FileCountMax::class;
  }
}
