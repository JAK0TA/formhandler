<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Finisher;

use Typoheads\Formhandler\Domain\Model\Config\Finisher\AbstractFinisherModel;
use Typoheads\Formhandler\Domain\Model\Config\Finisher\MailFinisherModel;
use Typoheads\Formhandler\Domain\Model\Config\FormModel;

/** Documentation:Start:Finishers/MailFinisher.rst.
 *
 *.. _mailfinisher:
 *
 *================
 *MailFinisher
 *================
 *
 *
 *
 *
 *Documentation:End
 */
class MailFinisher extends AbstractFinisher {
  public function process(FormModel &$formConfig, AbstractFinisherModel &$finisherConfig): void {
    if (!$finisherConfig instanceof MailFinisherModel) {
      return;
    }
  }
}
