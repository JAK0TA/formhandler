<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\Domain\Model\Config\Validator;

use Typoheads\Formhandler\Domain\Model\Config\FormModel;
use Typoheads\Formhandler\Domain\Model\Config\Validator\Field\FieldModel;
use Typoheads\Formhandler\Validator\AbstractValidator;

/** Documentation:Start:TocTree:Validators/Index.rst.
 *
 *.. _validators:
 *
 *==========
 *Validators
 *==========
 *
 *You can enter as many :ref:`Validators` as you like. Each entry requires a model name of the :ref:`Validator <Validators>`. Optionally you can enter a specific configuration for the :ref:`Validator <Validators>` in the config section. For detailed information about the available error checks have a look at the section :ref:`Error Checks <Error-Checks>`.
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **TypoScript Path**
 *     - plugin.tx_formhandler_form.settings.predefinedForms.[x].steps.[x].validators
 *
 *:ref:`DefaultValidator`
 *  This is the default :ref:`Validator <Validators>`, it supports all available :ref:`error checks <Error-Checks>`.
 *
 *.. toctree::
 *   :maxdepth: 2
 *   :hidden:
 *
 *   DefaultValidator
 *
 *Documentation:End
 */
abstract class AbstractValidatorModel {
  /** @var FieldModel[] */
  public array $fields = [];

  /** @var string[] */
  protected array $restrictErrorChecks = [];

  /**
   * @param array<string, mixed> $settings
   */
  abstract public function __construct(FormModel &$formConfig, array $settings);

  /**
   * @return class-string<AbstractValidator>
   */
  abstract public function class(): string;

  /**
   * @return string[]
   */
  public function restrictErrorChecks(): array {
    return $this->restrictErrorChecks;
  }
}
