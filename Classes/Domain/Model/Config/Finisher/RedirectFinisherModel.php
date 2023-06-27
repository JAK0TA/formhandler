<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Finisher;

use Typoheads\Formhandler\Finisher\RedirectFinisher;

class RedirectFinisherModel extends AbstractFinisherModel {
  public int $headerStatusCode = 303;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->class = RedirectFinisher::class;
    $this->returns = boolval($settings['returns'] ?? false);
    $this->headerStatusCode = intval($settings['headerStatusCode'] ?? 303);
  }
}
