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

use Typoheads\Formhandler\Finisher\RedirectFinisher;

/** Documentation:Start:Finishers/RedirectFinisher.rst.
 *
 *.. _redirectfinisher:
 *
 *================
 *RedirectFinisher
 *================
 *
 *Redirects to specified page after successful form submission.
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
 *..  code-block:: typoscript
 *
 *    Example Code:
 *
 *    finishers {
 *      Redirect {
 *        model = RedirectFinisher
 *        config {
 *          returns = true
 *          correctRedirectUrl = false
 *          additionalParams {
 *            postal_code = 1.customer.postalCode
 *            queryParam2 = valueIfNotFoundAsFieldName
 *          }
 *        }
 *      }
 *    }
 *
 ***Properties**
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **additionalParams**
 *     - Add additional parameters to the redirect URL. Each parameter can be a string
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - Array<String, String|Field name path>
 *   * - *Default*
 *     - Empty
 *   * - *Note*
 *     - The key String of Array<String, String|Field name path> will also be used as the parameter name.
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **correctRedirectUrl**
 *     - Replaces "&amp;" with "&" in URL
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - Boolean
 *   * - *Default*
 *     - False
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **headerStatusCode**
 *     - Set a custom header code set when redirecting to another page.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - Integer
 *   * - *Default*
 *     - 303
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **returns**
 *     - Tells the controller that after this :ref:`Finishers`, no other :ref:`Finishers` can be called!
 *   * -
 *     -
 *   * - *Mandatory*
 *     - True
 *   * - *Data Type*
 *     - Boolean
 *   * - *Note*
 *     - **MUST be set** to True otherwise the redirect can't be send to the browser.
 *
 *
 *Documentation:End
 */
class RedirectFinisherModel extends AbstractFinisherModel {
  /** @var array<string, string> */
  public readonly array $additionalParams;

  public readonly bool $correctRedirectUrl;

  public readonly int $headerStatusCode;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->returns = filter_var($settings['returns'] ?? false, FILTER_VALIDATE_BOOLEAN);
    $additionalParams = [];
    if (is_array($settings['additionalParams'] ?? false)) {
      foreach ($settings['additionalParams'] as $queryParam => $valueOrFieldName) {
        $additionalParams[strval($queryParam)] = strval($valueOrFieldName);
      }
    }
    $this->additionalParams = $additionalParams;

    $this->correctRedirectUrl = filter_var($settings['correctRedirectUrl'] ?? false, FILTER_VALIDATE_BOOLEAN);
    $this->headerStatusCode = intval($settings['headerStatusCode'] ?? 303);
  }

  public function class(): string {
    return RedirectFinisher::class;
  }
}
