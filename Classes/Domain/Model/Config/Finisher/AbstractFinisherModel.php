<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Finisher;

use TYPO3\CMS\Core\Http\RedirectResponse;
use Typoheads\Formhandler\Finisher\AbstractFinisher;

/** Documentation:Start:TocTree:Finishers/Index.rst.
 *
 *.. _finishers:
 *
 *=========
 *Finishers
 *=========
 *
 *You can enter as many Finisher as you like. Each entry requires a model name of the Finisher model. Optionally you can enter a specific configuration for the Finisher in the config section.
 *
 *.. toctree::
 *   :maxdepth: 2
 *   :hidden:
 *
 *   MailFinisher
 *   RedirectFinisher
 *
 *Documentation:End
 */
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
