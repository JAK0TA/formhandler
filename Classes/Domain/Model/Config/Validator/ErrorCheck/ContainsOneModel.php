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

use Typoheads\Formhandler\Validator\ErrorCheck\ContainsOne;

/** Documentation:Start:ErrorChecks/Strings/ContainsOne.rst.
 *
 *.. _containsone:
 *
 *===========
 *ContainsOne
 *===========
 *
 *Checks if a field contains at least one of the configured values
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
 *            privacy_policy.errorChecks {
 *              containsOne {
 *                model = ContainsOneModel
 *                words = Yes,Ja
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
 *   * - **words**
 *     - Comma separated list of words of which one must be in the value of a given field
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
class ContainsOneModel extends AbstractErrorCheckModel {
  public readonly string $words;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'ContainsOne';
    $this->words = strval($settings['words'] ?? '');
  }

  public function class(): string {
    return ContainsOne::class;
  }
}
