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

use Typoheads\Formhandler\Validator\ErrorCheck\DateRange;

/** Documentation:Start:ErrorChecks/DateTime/DateRange.rst.
 *
 *.. _daterange:
 *
 *===========
 *DateRange
 *===========
 *
 *Checks if a field value is between or equal a configured date range.
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
 *              dateRange {
 *                model = DateRange
 *                dateMax = 1995-10-24
 *                dateMin = 1950-1-1
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
 *   * - **dateMax**
 *     - Sets the max date a field value can be.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - True
 *   * - *Data Type*
 *     - String
 *   * - *Note*
 *     - Format must be YYYY-MM-DD e.g 2023-07-19.
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **dateMin**
 *     - Sets the min date a field value must be.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - True
 *   * - *Data Type*
 *     - String
 *   * - *Note*
 *     - Format must be YYYY-MM-DD e.g 2023-07-19.
 *
 *.. toctree::
 *   :maxdepth: 2
 *   :hidden:
 *
 *Documentation:End
 */
class DateRangeModel extends AbstractErrorCheckModel {
  public readonly int $dateMax;

  public readonly int $dateMin;

  public readonly string $format;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'DateRange';

    $this->format = 'Y-m-d';
    $this->dateMax = (\DateTime::createFromFormat($this->format, strval($settings['dateMax'] ?? '')) ?: new \DateTime())->getTimestamp();
    $this->dateMin = (\DateTime::createFromFormat($this->format, strval($settings['dateMin'] ?? '')) ?: new \DateTime())->getTimestamp();
  }

  public function class(): string {
    return DateRange::class;
  }
}
