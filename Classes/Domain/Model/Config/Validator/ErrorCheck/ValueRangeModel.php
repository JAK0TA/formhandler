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

use Typoheads\Formhandler\Validator\ErrorCheck\ValueRange;

/** Documentation:Start:ErrorChecks/Numbers/ValueRange.rst.
 *
 *.. _valuerange:
 *
 *============
 *ValueRange
 *============
 *
 *Checks if the value of a field is between or equal the configured values.
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
 *            age.errorChecks {
 *              valueRange {
 *                model = ValueRange
 *                valueMax = 100
 *                valueMin = 18
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
 *   * - **valueMax**
 *     - Sets the max value a field value can be.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - Float|Integer
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
 *   * - **valueMin**
 *     - Sets the min value a field value must be.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - Float|Integer
 *   * - *Default*
 *     - 0
 *
 *.. toctree::
 *   :maxdepth: 2
 *   :hidden:
 *
 *Documentation:End
 */
class ValueRangeModel extends AbstractErrorCheckModel {
  public readonly float|int $valueMax;

  public readonly float|int $valueMin;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'ValueRange';

    $valueMax = filter_var($settings['valueMax'] ?? 0, FILTER_VALIDATE_INT);
    if (false === $valueMax) {
      $valueMax = filter_var($settings['valueMax'] ?? 0, FILTER_VALIDATE_FLOAT) ?: 0;
    }
    $this->valueMax = $valueMax;

    $valueMin = filter_var($settings['valueMin'] ?? 0, FILTER_VALIDATE_INT);
    if (false === $valueMin) {
      $valueMin = filter_var($settings['valueMin'] ?? 0, FILTER_VALIDATE_FLOAT) ?: 0;
    }
    $this->valueMin = $valueMin;
  }

  public function class(): string {
    return ValueRange::class;
  }
}
