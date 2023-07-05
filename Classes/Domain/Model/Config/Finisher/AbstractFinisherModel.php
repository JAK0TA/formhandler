<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\Domain\Model\Config\Finisher;

use TYPO3\CMS\Core\Http\Response;
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
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **TypoScript Path**
 *     - plugin.tx_formhandler_form.settings.predefinedForms.[x].finishers
 *
 *:ref:`MailFinisher`
 *  Sends emails to specified addresses.
 *
 *:ref:`RedirectFinisher`
 *  Redirects to specified page after successful form submission.
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
  public ?Response $response = null;

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
