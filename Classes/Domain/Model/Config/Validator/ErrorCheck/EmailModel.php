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

use Typoheads\Formhandler\Validator\ErrorCheck\Email;

/** Documentation:Start:ErrorChecks/General/Email.rst.
 *
 *.. _email:
 *
 *=====
 *Email
 *=====
 *
 *Checks if a field contains a valid email and if a MX record exists for the domain of an email address.
 *
 *If the user enters an email address like "user@example.tld", Formhandler checks if a valid MX record exists for the domain "example.tld".
 *
 *This doesn't ensure that the mailbox "user@example.tld" exists or that the MX record points to a running server, but at least makes sure that there is a mail server setup for this domain.
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
 *              required {
 *                model = Required
 *              }
 *              email {
 *                model = Email
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
class EmailModel extends AbstractErrorCheckModel {
  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'Email';
    if (isset($settings['FIXME'])) {
    }
  }

  public function class(): string {
    return Email::class;
  }
}
