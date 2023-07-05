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

use Typoheads\Formhandler\Validator\ErrorCheck\Required;

/** Documentation:Start:ErrorChecks/General/Required.rst.
 *
 *.. _required:
 *
 *========
 *Required
 *========
 *
 *Checks if a field is filled in
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
 *            name.errorChecks {
 *              required {
 *                model = RequiredModel
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
class RequiredModel extends AbstractErrorCheckModel {
  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'Required';
    if (isset($settings['FIXME'])) {
    }
  }

  public function class(): string {
    return Required::class;
  }
}
