<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Finisher;

use Typoheads\Formhandler\Domain\Model\Config\Finisher\AbstractFinisherModel;
use Typoheads\Formhandler\Domain\Model\Config\Finisher\RedirectFinisherModel;
use Typoheads\Formhandler\Domain\Model\Config\FormModel;

class RedirectFinisher extends AbstractFinisher {
  public function process(FormModel &$formConfig, AbstractFinisherModel &$finisherConfig): void {
    if (!$finisherConfig instanceof RedirectFinisherModel) {
      return;
    }
  }
}
