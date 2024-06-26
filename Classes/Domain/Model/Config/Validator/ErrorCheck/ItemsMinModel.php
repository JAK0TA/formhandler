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

use Typoheads\Formhandler\Validator\ErrorCheck\ItemsMin;

/** Documentation:Start:ErrorChecks/Arrays/ItemsMin.rst.
 *
 *.. _itemsmin:
 *
 *========
 *ItemsMin
 *========
 *
 *Checks if a field contains at least the configured amount of items. (e.g. checkboxes)
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
 *              itemsMin {
 *                model = ItemsMin
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
class ItemsMinModel extends AbstractErrorCheckModel {
  public readonly int $itemsMin;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'ItemsMin';
    $this->itemsMin = filter_var($settings['itemsMin'] ?? 0, FILTER_VALIDATE_INT) ?: 0;
  }

  public function class(): string {
    return ItemsMin::class;
  }
}
