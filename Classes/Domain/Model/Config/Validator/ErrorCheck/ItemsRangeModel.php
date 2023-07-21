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

use Typoheads\Formhandler\Validator\ErrorCheck\ItemsRange;

/** Documentation:Start:ErrorChecks/Arrays/ItemsRange.rst.
 *
 *.. _itemsrange:
 *
 *============
 *ItemsRange
 *============
 *
 *Checks if a field contains values between or equal the configured amount of items. (e.g. checkboxes)
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
 *            interests.errorChecks {
 *              itemsRange {
 *                model = ItemsRange
 *                itemsMax = 10
 *                itemsMin = 1
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
 *   * - **itemsMax**
 *     - Sets the max amount of items a field value can contain.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - Integer
 *   * - *Default*
 *     - 0
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **itemsMin**
 *     - Sets the min amount of items a field value must contain.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - Integer
 *   * - *Default*
 *     - 0
 *
 *.. toctree::
 *   :maxdepth: 2
 *   :hidden:
 *
 *Documentation:End
 */
class ItemsRangeModel extends AbstractErrorCheckModel {
  public readonly int $itemsMax;

  public readonly int $itemsMin;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'ItemsRange';
    $this->itemsMax = filter_var($settings['itemsMax'] ?? 0, FILTER_VALIDATE_INT) ?: 0;
    $this->itemsMin = filter_var($settings['itemsMin'] ?? 0, FILTER_VALIDATE_INT) ?: 0;
  }

  public function class(): string {
    return ItemsRange::class;
  }
}
