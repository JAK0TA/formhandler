<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\PreProcessor;

use Typoheads\Formhandler\Domain\Model\Config\FormModel;
use Typoheads\Formhandler\Domain\Model\Config\PreProcessor\AbstractPreProcessorModel;
use Typoheads\Formhandler\Domain\Model\Config\PreProcessor\SetSelectOptionsPreProcessorModel;
use Typoheads\Formhandler\Domain\Model\Config\SelectOptionModel;

class SetSelectOptionsPreProcessor extends AbstractPreProcessor {
  public function process(FormModel &$formConfig, AbstractPreProcessorModel &$preProcessorConfig): void {
    if (!$preProcessorConfig instanceof SetSelectOptionsPreProcessorModel) {
      return;
    }

    foreach ($preProcessorConfig->options as $value => $title) {
      $formConfig->selectsOptions[$preProcessorConfig->name][] = new SelectOptionModel($value, $title);
    }
  }
}
