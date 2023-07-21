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
 *:ref:`Arrays`
 *  Array checks are useful when dealing with arrays of check boxes and similar cases.
 *
 *:ref:`Database`
 *  These checks allow you to ensure that a database record exists or doesn't exist.
 *
 *:ref:`Date & Time <DateTime>`
 *  Using these error checks you can force the user to enter a valid date or time. You can even check for a valid date range.
 *
 *:ref:`Numbers`
 *  If you want to perform error checks on numbers, e.g. if a field value is a valid integer, these checks are right for you.
 *
 *:ref:`Strings`
 *  These error checks allow various checks suitable for strings, f.e. checking if a string is at least 10 characters long or if a string contains a specific word.
 *
 *.. toctree::
 *   :maxdepth: 2
 *   :hidden:
 *
 *   General
 *   Arrays
 *   Database
 *   DateTime
 *   Numbers
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
/** Documentation:Start:ErrorChecks/Arrays.rst.
 *
 *.. _arrays:
 *
 *======
 *Arrays
 *======
 *
 *Array checks are useful when dealing with arrays of check boxes and similar cases.
 *
 *:ref:`ItemsMax`
 *  Checks if a field contains not more than the configured amount of items. (e.g. checkboxes)
 *
 *:ref:`ItemsMin`
 *  Checks if a field contains at least the configured amount of items. (e.g. checkboxes)
 *
 *:ref:`ItemsRange`
 *  Checks if a field contains values between or equal the configured amount of items. (e.g. checkboxes)
 *
 *.. toctree::
 *   :maxdepth: 2
 *   :hidden:
 *
 *   Arrays/ItemsMax
 *   Arrays/ItemsMin
 *   Arrays/ItemsRange
 *
 *Documentation:End
 */
/** Documentation:Start:ErrorChecks/Database.rst.
 *
 *.. _database:
 *
 *========
 *Database
 *========
 *
 *| These checks allow you to ensure that a database record exists or doesn't exist.
 *| This is useful for unique constraints like username or email address.
 *
 *| Please be aware of the fact that MySQL searches are in most cases not case sensitive!
 *| (https://dev.mysql.com/doc/refman/8.1/en/case-sensitivity.html)
 *
 *:ref:`TableLookup`
 *  Checks if the value of a field is or is not in a configured field in a configured table.
 *
 *.. toctree::
 *   :maxdepth: 2
 *   :hidden:
 *
 *   Database/TableLookup
 *
 *Documentation:End
 */
/** Documentation:Start:ErrorChecks/DateTime.rst.
 *
 *.. _datetime:
 *
 *===========
 *Date & Time
 *===========
 *
 *Using these error checks you can force the user to enter a valid date or time. You can even check for a valid date range.
 *
 *:ref:`AgeMax`
 *  Checks if a given date is less or equal the specified number of years.
 *
 *:ref:`AgeMin`
 *  Checks if a given date is at least the specified number of years.
 *
 *:ref:`Date`
 *  Checks if a field value is a valid date.
 *
 *:ref:`DateRange`
 *  Checks if a field value is between or equal a configured date range.
 *
 *:ref:`Time`
 *  Checks if a field value is a valid time.
 *
 *.. toctree::
 *   :maxdepth: 2
 *   :hidden:
 *
 *   DateTime/AgeMax
 *   DateTime/AgeMin
 *   DateTime/Date
 *   DateTime/DateRange
 *   DateTime/Time
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
 *:ref:`ContainsAll`
 *  Checks if a field contains all of the configured values.
 *
 *:ref:`ContainsNone`
 *  Checks if a field contains none of the configured values.
 *
 *:ref:`ContainsOne`
 *  Checks if a field contains at least one of the configured values.
 *
 *:ref:`ContainsOnly`
 *  Checks if a field contains only the configured characters.
 *
 *:ref:`LengthMax`
 *  Checks if the value of a field has less than the configured length.
 *
 *:ref:`LengthMin`
 *  Checks if the value of a field has at least the configured length.
 *
 *:ref:`LengthRange`
 *  Checks if the length of the value of a field is between or equal the configured values.
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
 *   Strings/ContainsOnly
 *   Strings/LengthMax
 *   Strings/LengthMin
 *   Strings/LengthRange
 *   Strings/PregMatch
 *
 *Documentation:End
 */
/** Documentation:Start:ErrorChecks/Numbers.rst.
 *
 *.. _numbers:
 *
 *=======
 *Numbers
 *=======
 *
 *If you want to perform error checks on numbers, e.g. if a field value is a valid integer, these checks are right for you.
 *
 *:ref:`Float`
 *  Checks if a field contains a valid float value.
 *
 *:ref:`Integer`
 *  Checks if a field contains a valid integer value.
 *
 *:ref:`ValueMax`
 *  Checks if the value of a field is less or equal than the configured value.
 *
 *:ref:`ValueMin`
 *  Checks if the value of a field is at least the configured value.
 *
 *:ref:`ValueRange`
 *  Checks if the value of a field is between or equal the configured values.
 *
 *.. toctree::
 *   :maxdepth: 2
 *   :hidden:
 *
 *   Numbers/Float
 *   Numbers/Integer
 *   Numbers/ValueMax
 *   Numbers/ValueMin
 *   Numbers/ValueRange
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
