<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\Domain\Model\Config\Logger;

use Typoheads\Formhandler\Logger\AbstractLogger;

/** Documentation:Start:TocTree:Loggers/Index.rst.
 *
 *.. _loggers:
 *
 *=======
 *Loggers
 *=======
 *
 *Loggers take care of logging every form submission.
 *
 *Logger\DB gets called by Formhandler automatically as its log data is used by various :ref:`Finishers` and Generators and the Backend Module.
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **TypoScript Path**
 *     - plugin.tx_formhandler_form.settings.predefinedForms.[x].loggers
 *
 *:ref:`DatabaseLogger`
 *  Will log into tx_formhandler_log. The logs can be accessed via the Formhandler backend module.
 *
 *.. toctree::
 *   :maxdepth: 2
 *   :hidden:
 *
 *   DatabaseLogger
 *
 *Documentation:End
 */
abstract class AbstractLoggerModel {
  /**
   * @param array<string, mixed> $settings
   */
  abstract public function __construct(array $settings);

  /**
   * @return class-string<AbstractLogger>
   */
  abstract public function class(): string;
}
