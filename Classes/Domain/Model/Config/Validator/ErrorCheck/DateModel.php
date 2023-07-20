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

use Typoheads\Formhandler\Validator\ErrorCheck\Date;

/** Documentation:Start:ErrorChecks/DateTime/Date.rst.
 *
 *.. _date:
 *
 *====
 *Date
 *====
 *
 *Checks if a field value is a valid date. Format must be YYYY-MM-DD e.g 2023-07-19.
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
 *              date {
 *                model = DateModel
 *              }
 *            }
 *          }
 *        }
 *      }
 *    }
 *
 *.. toctree::
 *   :maxdepth: 2
 *   :hidden:
 *
 *Documentation:End
 */
class DateModel extends AbstractErrorCheckModel {
  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'Date';
    $settings = $settings;
  }

  public function class(): string {
    return Date::class;
  }
}
