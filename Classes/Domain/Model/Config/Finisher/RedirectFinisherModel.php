<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Finisher;

class RedirectFinisherModel extends AbstractFinisherModel {
  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(
    protected readonly array $settings = []
  ) {
    parent::__construct($settings);

    $this->class = '\\Typoheads\\Formhandler\\Finisher\\RedirectFinisher';
  }
}
