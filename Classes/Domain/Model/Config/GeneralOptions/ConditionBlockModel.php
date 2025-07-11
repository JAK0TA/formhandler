<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\Domain\Model\Config\GeneralOptions;

/** Documentation:Start:GeneralOptions/ConditionBlock.rst.
 *
 *.. _conditionblock:
 *
 *===============
 *Condition Block
 *===============
 *
 *| Define several conditions to change the behavior of the form depending on user input.
 *| These conditions can be used to do different validation depending on what the user entered or selected before.
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **TypoScript Path**
 *     - plugin.tx_formhandler_form.settings.predefinedForms.[x].conditionBlocks
 *
 *..  code-block::
 *
 *    Example Code:
 *
 *    plugin.tx_formhandler_form.settings.predefinedForms.devExample {
 *      conditionBlocks {
 *        1 {
 *          conditions.OR1.AND1 = 1.customer.country=NONE
 *          isTrue {
 *            disableErrorCheckFields = 1.customer.city,1.customer.postalCode,1.customer.streetAddress,
 *          }
 *        }
 *        2 {
 *          conditions.OR1 {
 *            AND1 = 1.customer.payment=credit-card
 *          }
 *          isTrue {
 *            disableErrorCheckFields = 2.payment.bank,2.payment.IBAN,2.payment.accountHolder
 *          }
 *          else {
 *             # Do something if the condition was not true. This will not be needed often.
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
 *   * - **conditions**
 *     - The conditions for a given condition block.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - True
 *   * - *Data Type*
 *     - Array<String, Array<String, String>>
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **isTrue**
 *     - A list of disableErrorCheckFields for when the conditions are met.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - True
 *   * - *Data Type*
 *     - Array<String, String>
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **else**
 *     - A list of disableErrorCheckFields for when the conditions are not met.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - Array<String, String>
 *
 *Documentation:End
 */
class ConditionBlockModel {
  /** @var array<string, array<string, string>> */
  public readonly array $conditions;

  /** @var array<string, mixed> */
  public readonly array $else;

  /** @var array<string, mixed> */
  public readonly array $isTrue;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->conditions = $settings['conditions'] ?? [];
    $this->else = $settings['else'] ?? [];
    $this->isTrue = $settings['isTrue'] ?? [];
  }
}
