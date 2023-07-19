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

use Typoheads\Formhandler\Validator\ErrorCheck\ValueMin;

/** Documentation:Start:ErrorChecks/Numbers/ValueMin.rst.
 *
 *.. _valuemin:
 *
 *=========
 *ValueMin
 *=========
 *
 *Checks if the value of a field is at least the configured value.
 *
 *..  code-block:: typoscript
 *
 *    Example Code:
 *
 *    validators {
 *      DefaultValidator {
 *        model = DefaultValidatorModel
 *        config {
 *          fields {
 *            age.errorChecks {
 *              valueMin {
 *                model = ValueMinModel
 *                valueMin = 18
 *              }
 *            }
 *            mass.errorChecks {
 *              valueMin {
 *                model = ValueMinModel
 *                valueMin = 1.5
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
class ValueMinModel extends AbstractErrorCheckModel {
  public readonly float|int $valueMin;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'ValueMin';
    $valueMin = filter_var($settings['valueMin'] ?? 0, FILTER_VALIDATE_INT);
    if (false === $valueMin) {
      $valueMin = filter_var($settings['valueMin'] ?? 0, FILTER_VALIDATE_FLOAT) ?: 0;
    }
    $this->valueMin = $valueMin;
  }

  public function class(): string {
    return ValueMin::class;
  }
}
