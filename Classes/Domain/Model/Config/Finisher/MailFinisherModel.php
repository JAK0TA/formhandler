<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\Domain\Model\Config\Finisher;

use Typoheads\Formhandler\Finisher\MailFinisher;

/** Documentation:Start:Finishers/MailFinisher.rst.
 *
 *.. _mailfinisher:
 *
 *============
 *MailFinisher
 *============
 *
 *Sends emails to specified addresses.
 *
 *
 *Documentation:End
 */
class MailFinisherModel extends AbstractFinisherModel {
  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->returns = filter_var($settings['returns'] ?? false, FILTER_VALIDATE_BOOLEAN);
  }

  public function class(): string {
    return MailFinisher::class;
  }
}
