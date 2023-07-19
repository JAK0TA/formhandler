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

use Typoheads\Formhandler\Validator\ErrorCheck\ItemsMax;

/** Documentation:Start:ErrorChecks/Arrays/ItemsMax.rst.
 *
 *.. _itemsmax:
 *
 *========
 *ItemsMax
 *========
 *
 *Checks if a field contains not more than the configured amount of items. (e.g. checkboxes)
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
 *            interests.errorChecks {
 *              itemsMax {
 *                model = ItemsMaxModel
 *                itemsMax = 10
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
 *.. toctree::
 *   :maxdepth: 2
 *   :hidden:
 *
 *Documentation:End
 */
class ItemsMaxModel extends AbstractErrorCheckModel {
  public readonly int $itemsMax;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'ItemsMax';
    $this->itemsMax = filter_var($settings['itemsMax'] ?? 0, FILTER_VALIDATE_INT) ?: 0;
  }

  public function class(): string {
    return ItemsMax::class;
  }
}
