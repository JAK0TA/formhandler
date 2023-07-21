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

use Typoheads\Formhandler\Validator\ErrorCheck\PregMatch;

/** Documentation:Start:ErrorChecks/Strings/PregMatch.rst.
 *
 *.. _pregmatch:
 *
 *=========
 *PregMatch
 *=========
 *
 *Checks a field value using the configured perl regular expression.
 *
 *You can use this check to do existing check your own way or to make checks no built-in error check exists for.
 *
 *..  code-block::
 *
 *    Example Code:
 *
 *    validators {
 *      DefaultValidator {
 *        model = DefaultValidator
 *        config {
 *          fields {
 *            post-code.errorChecks {
 *              pregMatch {
 *                model = PregMatch
 *                pattern = /^DE-.*$/
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
 *   * - **pattern**
 *     - The regex pattern to search for, as a string.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - String
 *   * - *Default*
 *     - Empty String
 *
 *.. toctree::
 *   :maxdepth: 2
 *   :hidden:
 *
 *Documentation:End
 */
class PregMatchModel extends AbstractErrorCheckModel {
  public readonly string $pattern;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'PregMatch';
    $this->pattern = strval($settings['pattern'] ?? '');
  }

  public function class(): string {
    return PregMatch::class;
  }
}
