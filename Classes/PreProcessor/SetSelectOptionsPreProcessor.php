<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\PreProcessor;

use Typoheads\Formhandler\Domain\Model\Config\FormModel;
use Typoheads\Formhandler\Domain\Model\Config\PreProcessor\AbstractPreProcessorModel;
use Typoheads\Formhandler\Domain\Model\Config\PreProcessor\SetSelectOptionsPreProcessorModel;
use Typoheads\Formhandler\Domain\Model\Config\SelectOptionModel;

class SetSelectOptionsPreProcessor extends AbstractPreProcessor {
  public function process(FormModel &$formConfig, AbstractPreProcessorModel $preProcessorConfig): void {
    if (!$preProcessorConfig instanceof SetSelectOptionsPreProcessorModel) {
      return;
    }

    foreach ($preProcessorConfig->options as $value => $title) {
      $formConfig->fieldsSelectOptions[$preProcessorConfig->field][] = new SelectOptionModel($value, $title);
    }
  }
}
