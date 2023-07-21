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

use Typoheads\Formhandler\Utility\Utility;
use Typoheads\Formhandler\Validator\ErrorCheck\TableLookup;

/** Documentation:Start:ErrorChecks/Database/TableLookup.rst.
 *
 *.. _tablelookup:
 *
 *===========
 *TableLookup
 *===========
 *
 *Checks if the value of a field is or is not in a configured field in a configured table.
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
 *            email.errorChecks {
 *              tableLookup {
 *                model = TableLookup
 *                table = fe_users
 *                field = email
 *                exists = False
 *                excludeHidden = True
 *                additionalWhere = FIND_IN_SET(1, usergroup)
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
 *   * - **table**
 *     - The name of the database table.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - True
 *   * - *Data Type*
 *     - String
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **field**
 *     - The name of the field in the database table.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - True
 *   * - *Data Type*
 *     - String
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **exists**
 *     - Set true if the value must already exist.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - Boolean
 *   * - *Default*
 *     - False
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **excludeHidden**
 *     - Set true to exclude hidden records from lookup.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - Boolean
 *   * - *Default*
 *     - False
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **additionalWhere**
 *     - Add your own conditions here to fit your needs. Like only lookup a certain user group, etc.
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
class TableLookupModel extends AbstractErrorCheckModel {
  public readonly string $additionalWhere;

  public readonly bool $excludeHidden;

  public readonly bool $exists;

  public readonly string $field;

  public readonly string $table;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'TableLookup';
    $this->additionalWhere = Utility::prepareAndWhereString(strval($settings['additionalWhere'] ?? ''));
    $this->excludeHidden = filter_var($settings['excludeHidden'] ?? false, FILTER_VALIDATE_BOOLEAN) ?: false;
    $this->exists = filter_var($settings['exists'] ?? false, FILTER_VALIDATE_BOOLEAN) ?: false;
    $this->field = strval($settings['field'] ?? '');
    $this->table = strval($settings['table'] ?? '');
  }

  public function class(): string {
    return TableLookup::class;
  }
}
