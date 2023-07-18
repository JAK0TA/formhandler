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

use Typoheads\Formhandler\Validator\ErrorCheck\AbstractErrorCheck;

/** Documentation:Start:TocTree:ErrorChecks/Index.rst.
 *
 *.. _error-checks:
 *
 *============
 *Error Checks
 *============
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **TypoScript Path**
 *     - plugin.tx_formhandler_form.settings.predefinedForms.[x].steps.[x].validators.[x].config.fields.[x].errorChecks
 *
 *:ref:`General`
 *  These checks perform basic validation routines like checking if a field is filled out or if a field value is a valid email address.
 *
 *:ref:`Strings`
 *  These error checks allow various checks suitable for strings, f.e. checking if a string is at least 10 characters long or if a string contains a specific word.
 *
 *.. toctree::
 *   :maxdepth: 2
 *   :hidden:
 *
 *   General
 *   Strings
 *
 *Documentation:End
 */
/** Documentation:Start:ErrorChecks/General.rst.
 *
 *.. _general:
 *
 *=======
 *General
 *=======
 *
 *These checks perform basic validation routines like checking if a field is filled out or if a field value is a valid email address.
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
 *            firstname.errorChecks {
 *              required {
 *                model = RequiredModel
 *              }
 *            }
 *          }
 *        }
 *      }
 *    }
 *
 *:ref:`Email`
 *  Checks if a field contains a valid email and if a MX record exists for the domain of an email address.
 *
 *:ref:`Equals`
 *  Checks if a field equals the configured value.
 *
 *:ref:`EqualsField`
 *  Checks if a field value equals another field value.
 *
 *:ref:`NotEqualsField`
 *  Checks if a field value does not equals another field value.
 *
 *:ref:`Required`
 *  Checks if a field is filled in
 *
 *:ref:`Url`
 *  Checks if a field contains a valid url.
 *
 *.. toctree::
 *   :maxdepth: 2
 *   :hidden:
 *
 *   General/Email
 *   General/Equals
 *   General/EqualsField
 *   General/NotEqualsField
 *   General/Required
 *   General/Url
 *
 *Documentation:End
 */
/** Documentation:Start:ErrorChecks/Strings.rst.
 *
 *.. _strings:
 *
 *=======
 *Strings
 *=======
 *
 *These error checks allow various checks suitable for strings, f.e. checking if a string is at least 10 characters long or if a string contains a specific word.
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
 *            firstname.errorChecks {
 *              lengthMin {
 *                model = LengthMinModel
 *                lengthMin = 10
 *              }
 *              lengthMax {
 *                model = LengthMaxModel
 *                lengthMax = 20
 *              }
 *            }
 *          }
 *        }
 *      }
 *    }
 *
 *:ref:`ContainsAll`
 *  Checks if a field contains all of the configured values.
 *
 *:ref:`ContainsNone`
 *  Checks if a field contains none of the configured values.
 *
 *:ref:`ContainsOne`
 *  Checks if a field contains at least one of the configured values.
 *
 *:ref:`LengthBetween`
 *  Checks if the length of the value of a field is between or equal the configured values.
 *
 *:ref:`LengthMax`
 *  Checks if the value of a field has less than the configured length.
 *
 *:ref:`LengthMin`
 *  Checks if the value of a field has at least the configured length.
 *
 *:ref:`PregMatch`
 *  Checks a field value using the configured perl regular expression.
 *
 *.. toctree::
 *   :maxdepth: 2
 *   :hidden:
 *
 *   Strings/ContainsAll
 *   Strings/ContainsNone
 *   Strings/ContainsOne
 *   Strings/LengthBetween
 *   Strings/LengthMax
 *   Strings/LengthMin
 *   Strings/PregMatch
 *
 *Documentation:End
 */
abstract class AbstractErrorCheckModel {
  public string $name;

  /**
   * @param array<string, mixed> $settings
   */
  abstract public function __construct(array $settings);

  /**
   * @return class-string<AbstractErrorCheck>
   */
  abstract public function class(): string;
}
