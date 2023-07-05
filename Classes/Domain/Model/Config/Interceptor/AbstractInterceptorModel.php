<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\Domain\Model\Config\Interceptor;

use Typoheads\Formhandler\Interceptor\AbstractInterceptor;

/** Documentation:Start:TocTree:Interceptors/Index.rst.
 *
 *.. _interceptors:
 *
 *============
 *Interceptors
 *============
 *
 *You can enter as many Interceptors as you like. Each entry requires a model name of the Interceptor. Optionally you can enter specific configuration for the Interceptor in the config section.
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **TypoScript Path**
 *     - plugin.tx_formhandler_form.settings.predefinedForms.[x].(init/save)Interceptors
 *
 *:ref:`InitInterceptors`
 *  The init interceptors are called before every time the form is displayed or the :ref:`Validators` are called.
 *
 *:ref:`SaveInterceptors`
 *  The save interceptors are called after all steps are validated and before the :ref:`Loggers` and :ref:`Finishers` are called.
 *
 *.. toctree::
 *   :maxdepth: 2
 *   :hidden:
 *
 *   InitInterceptors
 *   SaveInterceptors
 *
 *Documentation:End
 */
/** Documentation:Start:Interceptors/InitInterceptors.rst.
 *
 *.. _initinterceptors:
 *
 *=================
 *Init Interceptors
 *=================
 *
 *The init interceptors are called before every time the form is displayed.
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **TypoScript Path**
 *     - plugin.tx_formhandler_form.settings.predefinedForms.[x].initInterceptors
 *
 *.. toctree::
 *   :maxdepth: 2
 *   :hidden:
 *
 *Documentation:End
 */
/** Documentation:Start:Interceptors/SaveInterceptors.rst.
 *
 *.. _saveinterceptors:
 *
 *=================
 *Save Interceptors
 *=================
 *
 *The save interceptors are called after all steps are validated and before the loggers and finishers are called.
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **TypoScript Path**
 *     - plugin.tx_formhandler_form.settings.predefinedForms.[x].saveInterceptors
 *
 *.. toctree::
 *   :maxdepth: 2
 *   :hidden:
 *
 *Documentation:End
 */
abstract class AbstractInterceptorModel {
  /**
   * @param array<string, mixed> $settings
   */
  abstract public function __construct(array $settings);

  /**
   * @return class-string<AbstractInterceptor>
   */
  abstract public function class(): string;
}
