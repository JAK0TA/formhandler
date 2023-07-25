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

use Typoheads\Formhandler\Validator\ErrorCheck\FileCountMin;

/** Documentation:Start:ErrorChecks/FileUpload/FileCountMin.rst.
 *
 *.. _filecountmin:
 *
 *============
 *FileCountMin
 *============
 *
 *Checks if the files uploaded from a field are more than or equal the configured value.
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
 *              fileCountMin {
 *                model = FileCountMin
 *                fileCountMin = 1
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
 *   * - **fileCountMin**
 *     - Sets the min amount of files a field must upload.
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
class FileCountMinModel extends AbstractErrorCheckModel {
  public readonly int $fileCountMin;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'FileCountMin';
    $this->fileCountMin = filter_var($settings['fileCountMin'] ?? 0, FILTER_VALIDATE_INT) ?: 0;
  }

  public function class(): string {
    return FileCountMin::class;
  }
}
