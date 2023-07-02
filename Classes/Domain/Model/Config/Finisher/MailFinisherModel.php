<?php

declare(strict_types=1);

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
 *
 *
 *
 *Documentation:End
 */
class MailFinisherModel extends AbstractFinisherModel {
  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->returns = boolval($settings['returns'] ?? false);
  }

  public function class(): string {
    return MailFinisher::class;
  }
}
