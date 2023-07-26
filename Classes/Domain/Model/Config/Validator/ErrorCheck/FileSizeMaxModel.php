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

use Typoheads\Formhandler\Validator\ErrorCheck\FileSizeMax;

/** Documentation:Start:ErrorChecks/FileUpload/FileSizeMax.rst.
 *
 *.. _filesizemax:
 *
 *===========
 *FileSizeMax
 *===========
 *
 *Checks if the size of an uploaded file is less or equal than the configured value.
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
 *              fileSizeMax {
 *                model = FileSizeMax
 *                fileSizeMax = 52428800
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
 *   * - **fileSizeMax**
 *     - Sets the max size a uploaded file can be. (in Byte)
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - False|Integer
 *   * - *Default*
 *     - False
 *
 *.. toctree::
 *   :maxdepth: 2
 *   :hidden:
 *
 *Documentation:End
 */
class FileSizeMaxModel extends AbstractErrorCheckModel {
  public readonly false|int $fileSizeMax;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'FileSizeMax';
    $this->fileSizeMax = filter_var($settings['fileSizeMax'] ?? null, FILTER_VALIDATE_INT);
  }

  public function class(): string {
    return FileSizeMax::class;
  }
}
