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

use Typoheads\Formhandler\Validator\ErrorCheck\FloatValue;

/** Documentation:Start:ErrorChecks/Numbers/Float.rst.
 *
 *.. _float:
 *
 *=====
 *Float
 *=====
 *
 *Checks if a field contains a valid float value.
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
 *            mass.errorChecks {
 *              float {
 *                model = Float
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
class FloatModel extends AbstractErrorCheckModel {
  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'FloatValue';
    $settings = $settings;
  }

  public function class(): string {
    return FloatValue::class;
  }
}
