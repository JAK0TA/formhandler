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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Typoheads\Formhandler\Validator\ErrorCheck\ContainsNone;

/** Documentation:Start:ErrorChecks/Strings/ContainsNone.rst.
 *
 *.. _containsnone:
 *
 *============
 *ContainsNone
 *============
 *
 *Checks if a field contains none of the configured values.
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
 *            message.errorChecks {
 *              containsNone {
 *                model = ContainsNoneModel
 *                values = motherforking,shirtballs,badword
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
 *   * - **values**
 *     - Comma separated list of values of which none must be present in the value of a given field
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
class ContainsNoneModel extends AbstractErrorCheckModel {
  /** @var string[] */
  public readonly array $values;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'ContainsNone';
    $this->values = GeneralUtility::trimExplode(',', strval($settings['values'] ?? ''));
  }

  public function class(): string {
    return ContainsNone::class;
  }
}
