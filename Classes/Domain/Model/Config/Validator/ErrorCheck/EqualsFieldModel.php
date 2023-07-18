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

use Typoheads\Formhandler\Validator\ErrorCheck\EqualsField;

/** Documentation:Start:ErrorChecks/General/EqualsField.rst.
 *
 *.. _equalsfield:
 *
 *===========
 *EqualsField
 *===========
 *
 *Checks if a field value equals another field value.
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
 *            password_repeat.errorChecks {
 *              equalsField {
 *                model = EqualsFieldModel
 *                field = 1.password
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
 *   * - **field**
 *     - Path name of the field that must be equal to the value of a given field
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
class EqualsFieldModel extends AbstractErrorCheckModel {
  /** @var string[] */
  public readonly array $field;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'EqualsField';
    $this->field = explode('.', trim(strval($settings['field'] ?? '')));
  }

  public function class(): string {
    return EqualsField::class;
  }
}
