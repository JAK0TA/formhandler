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

use Typoheads\Formhandler\Validator\ErrorCheck\FileSizeMin;

/** Documentation:Start:ErrorChecks/FileUpload/FileSizeMin.rst.
 *
 *.. _filesizemin:
 *
 *===========
 *FileSizeMin
 *===========
 *
 *Checks if the size of an uploaded file is at least the configured value.
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
 *              fileSizeMin {
 *                model = FileSizeMin
 *                fileSizeMin = 1048576
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
 *   * - **fileSizeMin**
 *     - Sets the min size a uploaded file must be. (in Byte)
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
class FileSizeMinModel extends AbstractErrorCheckModel {
  public readonly false|int $fileSizeMin;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'FileSizeMin';
    $this->fileSizeMin = filter_var($settings['fileSizeMin'] ?? null, FILTER_VALIDATE_INT);
  }

  public function class(): string {
    return FileSizeMin::class;
  }
}
