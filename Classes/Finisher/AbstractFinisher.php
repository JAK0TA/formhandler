<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Finisher;

use TYPO3\CMS\Core\SingletonInterface;
use Typoheads\Formhandler\Domain\Model\Config\Finisher\AbstractFinisherModel;
use Typoheads\Formhandler\Domain\Model\Config\FormModel;

/** Documentation:Start:TocTree:Finishers/Index.rst.
 *
 *.. _finishers:
 *
 *Finishers
 *==========
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
abstract class AbstractFinisher implements SingletonInterface {
  abstract public function process(FormModel &$formConfig, AbstractFinisherModel &$finisherConfig): void;
}
