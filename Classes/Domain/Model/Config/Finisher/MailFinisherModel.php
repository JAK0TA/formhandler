<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Finisher;

use Typoheads\Formhandler\Finisher\MailFinisher;

class MailFinisherModel extends AbstractFinisherModel {
  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->class = MailFinisher::class;
    $this->returns = boolval($settings['returns'] ?? false);
  }
}
