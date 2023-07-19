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

use Typoheads\Formhandler\Validator\ErrorCheck\ValueMax;

/** Documentation:Start:ErrorChecks/Numbers/ValueMax.rst.
 *
 *.. _valuemax:
 *
 *========
 *ValueMax
 *========
 *
 *Checks if the value of a field is less or equal than the configured value.
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
 *              valueMax {
 *                model = ValueMaxModel
 *                valueMax = 100
 *              }
 *            }
 *            mass.errorChecks {
 *              valueMax {
 *                model = ValueMaxModel
 *                valueMax = 10.99
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
 *.. toctree::
 *   :maxdepth: 2
 *   :hidden:
 *
 *Documentation:End
 */
class ValueMaxModel extends AbstractErrorCheckModel {
  public readonly float|int $valueMax;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'ValueMax';

    $valueMax = filter_var($settings['valueMax'] ?? 0, FILTER_VALIDATE_INT);
    if (false === $valueMax) {
      $valueMax = filter_var($settings['valueMax'] ?? 0, FILTER_VALIDATE_FLOAT) ?: 0;
    }
    $this->valueMax = $valueMax;
  }

  public function class(): string {
    return ValueMax::class;
  }
}
