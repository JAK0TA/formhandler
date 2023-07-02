<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Finisher;

use Typoheads\Formhandler\Finisher\RedirectFinisher;

/** Documentation:Start:Finishers/RedirectFinisher.rst.
 *
 *.. _redirectfinisher:
 *
 *================
 *RedirectFinisher
 *================
 *
 *
 *
 *
 *Documentation:End
 */
class RedirectFinisherModel extends AbstractFinisherModel {
  /** @var array<string, string> */
  public readonly array $additionalParams;

  public readonly bool $correctRedirectUrl;

  public readonly int $headerStatusCode;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->returns = boolval($settings['returns'] ?? false);
    $additionalParams = [];
    if (is_array($settings['additionalParams'] ?? false)) {
      foreach ($settings['additionalParams'] as $queryParam => $valueOrFieldName) {
        $additionalParams[strval($queryParam)] = strval($valueOrFieldName);
      }
    }
    $this->additionalParams = $additionalParams;

    $this->correctRedirectUrl = boolval($settings['correctRedirectUrl'] ?? false);
    $this->headerStatusCode = intval($settings['headerStatusCode'] ?? 303);
  }

  public function class(): string {
    return RedirectFinisher::class;
  }
}
