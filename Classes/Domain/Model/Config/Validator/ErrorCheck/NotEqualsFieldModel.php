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

use Typoheads\Formhandler\Validator\ErrorCheck\NotEqualsField;

/** Documentation:Start:ErrorChecks/General/NotEqualsField.rst.
 *
 *.. _notequalsfield:
 *
 *==============
 *NotEqualsField
 *==============
 *
 *Checks if a field value does not equals another field value.
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
 *            password.errorChecks {
 *              notEqualsField {
 *                model = NotEqualsFieldModel
 *                field = 1.username
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
 *     - Path name of the field that must not be equal to the value of a given field
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
class NotEqualsFieldModel extends AbstractErrorCheckModel {
  /** @var string[] */
  public readonly array $field;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'NotEqualsField';
    $this->field = explode('.', trim(strval($settings['field'] ?? '')));
  }

  public function class(): string {
    return NotEqualsField::class;
  }
}
