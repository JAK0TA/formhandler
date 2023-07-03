<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck;

use Typoheads\Formhandler\Validator\ErrorCheck\MaxLength;

/** Documentation:Start:ErrorChecks/Strings/MaxLength.rst.
 *
 *.. _maxlength:
 *
 *=========
 *MaxLength
 *=========
 *
 *Checks if the value of a field has less than the configured length
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
 *            post-code.errorChecks {
 *              maxLength {
 *                model = MaxLengthModel
 *                maxLength = 7
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
 *   * - **maxLength**
 *     - Sets the max string length a field value can be.
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
class MaxLengthModel extends AbstractErrorCheckModel {
  public readonly int $maxLength;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'MaxLength';
    $this->maxLength = intval($settings['maxLength'] ?? 0);
  }

  public function class(): string {
    return MaxLength::class;
  }
}
