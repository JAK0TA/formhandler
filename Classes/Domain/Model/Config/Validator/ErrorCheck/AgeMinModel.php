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

use Typoheads\Formhandler\Validator\ErrorCheck\AgeMin;

/** Documentation:Start:ErrorChecks/DateTime/AgeMin.rst.
 *
 *.. _agemin:
 *
 *======
 *AgeMin
 *======
 *
 *Checks if a given date is at least the specified number of years.
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
 *            birthdate.errorChecks {
 *              ageMin {
 *                model = AgeMinModel
 *                ageMin = 18
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
 *   * - **ageMin**
 *     - Sets the min years to check a field date value for.
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
class AgeMinModel extends AbstractErrorCheckModel {
  public readonly int $ageMin;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'AgeMin';
    $this->ageMin = filter_var($settings['ageMin'] ?? 0, FILTER_VALIDATE_INT) ?: 0;
  }

  public function class(): string {
    return AgeMin::class;
  }
}
