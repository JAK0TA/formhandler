<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Finisher;

use Typoheads\Formhandler\Finisher\RedirectFinisher;

class RedirectFinisherModel extends AbstractFinisherModel {
  /** @var array<string, string> */
  public array $additionalParams = [];

  public bool $correctRedirectUrl = false;

  public int $headerStatusCode = 303;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->class = RedirectFinisher::class;
    $this->returns = boolval($settings['returns'] ?? false);
    if (is_array($settings['additionalParams'] ?? false)) {
      foreach ($settings['additionalParams'] as $queryParam => $valueOrFieldName) {
        $this->additionalParams[strval($queryParam)] = strval($valueOrFieldName);
      }
    }
    $this->correctRedirectUrl = boolval($settings['correctRedirectUrl'] ?? false);
    $this->headerStatusCode = intval($settings['headerStatusCode'] ?? 303);
  }
}
