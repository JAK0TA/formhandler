<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\Domain\Model\Config\Debugger;

use Typoheads\Formhandler\Debugger\PrintToScreenDebugger;
use Typoheads\Formhandler\Definitions\Severity;

/** Documentation:Start:Debuggers/PrintToScreenDebugger.rst.
 *
 *.. _printtoscreendebugger:
 *
 *=====================
 *PrintToScreenDebugger
 *=====================
 *
 *Will print out the debug messages to screen.
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **TypoScript Path**
 *     - plugin.tx_formhandler_form.settings.predefinedForms.[x].debuggers.PrintToScreenDebugger
 *
 *..  code-block:: typoscript
 *
 *    Example Code:
 *
 *    plugin.tx_formhandler_form.settings.predefinedForms.devExample {
 *      debuggers {
 *        PrintToScreenDebugger {
 *          model = PrintToScreenDebugger
 *          config {
 *            active = true
 *            maxDepth = 10
 *            severityWrap {
 *              1 = <span class="level-info">|</span>
 *              2 = <span class="level-warning">|</span>
 *              3 = <span class="level-error">|</span>
 *            }
 *          }
 *        }
 *      }
 *    }
 *
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
 *   * - **active**
 *     - Status of the debugger
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
 *   * - **maxDepth**
 *     - Sets the max recursion depth of the dump. De- or increase the number according to your needs and memory limit.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - Integer
 *   * - *Default*
 *     - 8
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **messageWrap**
 *     - Wrap for a single debug message
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - String
 *   * - *Default*
 *     - <div style="font-weight:bold;">|</div>
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **sectionHeaderWrap**
 *     - Wrap for a section header
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - String
 *   * - *Default*
 *     - <h2 style="background:#333; color:#cdcdcd; height:23px; padding:10px 7px 7px 7px; margin:0;">|</h2>
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **sectionWrap**
 *     - Wrap for a section (e.g. all log messages of a component are wrapped in a section)
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - String
 *   * - *Default*
 *     - <div style="border:1px solid #ccc; padding:7px; background:#dedede;">|</div>
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **blacklistedPropertyNames**
 *     - Use this to configure different appearance of different log severity levels.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - Array<Integer, String>
 *   * - *Default*
 *     - | severityWrap {
 *       | 1 = <span class="level-info">|</span>
 *       | 2 = <span class="level-warning">|</span>
 *       | 3 = <span class="level-error">|</span>
 *       | }
 *   * - *Note*
 *     - The key Integer in Array<Integer, String> is the severity level (1-3).
 *
 *Documentation:End
 */
class PrintToScreenDebuggerModel extends AbstractDebuggerModel {
  public readonly bool $active;

  public readonly int $maxDepth;

  public readonly string $messageWrap;

  public readonly string $sectionHeaderWrap;

  public readonly string $sectionWrap;

  /** @var array<int, string> */
  public readonly array $severityWrap;

  /**
   * @param array<string, mixed> $config
   */
  public function __construct(array $config) {
    $this->active = filter_var($config['active'] ?? false, FILTER_VALIDATE_BOOLEAN);

    $this->maxDepth = intval($config['maxDepth'] ?? 8);

    $this->messageWrap = strval($config['messageWrap'] ?? '<div style="font-weight:bold;">|</div>');
    $this->sectionHeaderWrap = strval($config['sectionHeaderWrap'] ?? '<h2 style="background:#333; color:#cdcdcd;height:23px;padding:10px 7px 7px 7px;margin:0;">|</h2>');
    $this->sectionWrap = strval($config['sectionWrap'] ?? '<div style="border:1px solid #ccc; padding:7px; background:#dedede;">|</div>');

    $SeverityInfoDefault = '<span style="color:#000;">|</span>';
    $SeverityWarningDefault = '<span style="color:#ff8c00;">|</span>';
    $SeverityErrorDefault = '<span style="color:#ff2800;">|</span>';

    if (isset($config['severityWrap']) && is_array($config['severityWrap'])) {
      $severityWrap[Severity::Info] = $config['severityWrap'][Severity::Info] ?? $SeverityInfoDefault;
      $severityWrap[Severity::Warning] = $config['severityWrap'][Severity::Info] ?? $SeverityWarningDefault;
      $severityWrap[Severity::Error] = $config['severityWrap'][Severity::Info] ?? $SeverityErrorDefault;

      $this->severityWrap = $severityWrap;
    } else {
      $severityWrap[Severity::Info] = $SeverityInfoDefault;
      $severityWrap[Severity::Warning] = $SeverityWarningDefault;
      $severityWrap[Severity::Error] = $SeverityErrorDefault;
      $this->severityWrap = $severityWrap;
    }
  }

  public function class(): string {
    return PrintToScreenDebugger::class;
  }
}
