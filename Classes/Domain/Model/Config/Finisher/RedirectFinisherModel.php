<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Finisher;

use Typoheads\Formhandler\Finisher\RedirectFinisher;

class RedirectFinisherModel extends AbstractFinisherModel {
  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->class = RedirectFinisher::class;
    if (isset($settings['FIXME'])) {
    }
  }
}
