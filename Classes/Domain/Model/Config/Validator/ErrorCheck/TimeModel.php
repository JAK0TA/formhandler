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

use Typoheads\Formhandler\Validator\ErrorCheck\Time;

/** Documentation:Start:ErrorChecks/DateTime/Time.rst.
 *
 *.. _time:
 *
 *====
 *Time
 *====
 *
 *Checks if a field value is a valid time. Format must be HH:MM:SS or HH:MM e.g 13:07:19 or 13:07.
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
 *            start_time.errorChecks {
 *              time {
 *                model = Time
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
class TimeModel extends AbstractErrorCheckModel {
  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'Time';
    $settings = $settings;
  }

  public function class(): string {
    return Time::class;
  }
}
