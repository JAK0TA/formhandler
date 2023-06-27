<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Finisher;

use TYPO3\CMS\Core\SingletonInterface;
use Typoheads\Formhandler\Domain\Model\Config\Finisher\AbstractFinisherModel;
use Typoheads\Formhandler\Domain\Model\Config\FormModel;

abstract class AbstractFinisher implements SingletonInterface {
  abstract public function process(FormModel &$formConfig, AbstractFinisherModel $finisherConfig): void;
}
