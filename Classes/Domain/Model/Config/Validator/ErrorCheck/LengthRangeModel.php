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

use Typoheads\Formhandler\Validator\ErrorCheck\LengthRange;

/** Documentation:Start:ErrorChecks/Strings/LengthRange.rst.
 *
 *.. _lengthrange:
 *
 *=============
 *LengthRange
 *=============
 *
 *Checks if the length of the value of a field is between or equal the configured values.
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
 *            post-code.errorChecks {
 *              lengthRange {
 *                model = LengthRange
 *                lengthMax = 10
 *                lengthMin = 7
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
 *   * - **lengthMax**
 *     - Sets the max string length a field value can be.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - Integer
 *   * - *Default*
 *     - 0
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **lengthMin**
 *     - Sets the min string length a field value must be.
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
class LengthRangeModel extends AbstractErrorCheckModel {
  public readonly int $lengthMax;

  public readonly int $lengthMin;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'LengthRange';
    $this->lengthMax = intval($settings['lengthMax'] ?? 0);
    $this->lengthMin = intval($settings['lengthMin'] ?? 0);
  }

  public function class(): string {
    return LengthRange::class;
  }
}
