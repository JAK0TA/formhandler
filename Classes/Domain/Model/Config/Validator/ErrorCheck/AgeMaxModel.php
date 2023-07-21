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

use Typoheads\Formhandler\Validator\ErrorCheck\AgeMax;

/** Documentation:Start:ErrorChecks/DateTime/AgeMax.rst.
 *
 *.. _agemax:
 *
 *======
 *AgeMax
 *======
 *
 *Checks if a given date is less or equal the specified number of years.
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
 *            birthdate.errorChecks {
 *              ageMax {
 *                model = AgeMax
 *                ageMax = 14
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
 *   * - **ageMax**
 *     - Sets the max years to check a field date value for.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - Integer
 *   * - *Default*
 *     - 0
 *   * - *Note*
 *     - Date field format must be YYYY-MM-DD e.g 2000-07-19.
 *
 *.. toctree::
 *   :maxdepth: 2
 *   :hidden:
 *
 *Documentation:End
 */
class AgeMaxModel extends AbstractErrorCheckModel {
  public readonly int $ageMax;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'AgeMin';
    $this->ageMax = filter_var($settings['ageMax'] ?? 0, FILTER_VALIDATE_INT) ?: 0;
  }

  public function class(): string {
    return AgeMax::class;
  }
}
