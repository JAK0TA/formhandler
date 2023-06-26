<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\PreProcessor;

use TYPO3\CMS\Core\SingletonInterface;
use Typoheads\Formhandler\Domain\Model\Config\FormModel;
use Typoheads\Formhandler\Domain\Model\Config\PreProcessor\AbstractPreProcessorModel;

abstract class AbstractPreProcessor implements SingletonInterface {
  abstract public function process(FormModel &$formConfig, AbstractPreProcessorModel $preProcessorConfig): void;
}
