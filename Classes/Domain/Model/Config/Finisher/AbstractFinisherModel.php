<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Finisher;

use TYPO3\CMS\Core\Http\RedirectResponse;
use Typoheads\Formhandler\Finisher\AbstractFinisher;

abstract class AbstractFinisherModel {
  public ?RedirectResponse $redirectResponse = null;

  public bool $returns = false;

  /**
   * @param array<string, mixed> $settings
   */
  abstract public function __construct(array $settings);

  /**
   * @return class-string<AbstractFinisher>
   */
  abstract public function class(): string;
}
