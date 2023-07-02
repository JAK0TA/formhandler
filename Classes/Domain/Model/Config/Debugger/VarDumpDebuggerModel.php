<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Debugger;

use Typoheads\Formhandler\Debugger\VarDumpDebugger;

/** Documentation:Start:Debuggers/VarDumpDebugger.rst.
 *
 *.. _vardumpdebugger:
 *
 *===============
 *VarDumpDebugger
 *===============
 *
 *Will print out the debug messages to screen as VarDump.
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **TypoScript Path**
 *     - plugin.tx_formhandler_form.settings.predefinedForms.[x].debuggers.VarDumpDebugger
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
 *   * - **ansiColors**
 *     - If True, ANSI color codes is added to the output, if False the debug output is not colored.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - Boolean
 *   * - *Default*
 *     - True
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **blacklistedClassNames**
 *     - An array of class names (RegEx) to be filtered. Default is an array of some common class names.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - Array<Integer, String>|Null
 *   * - *Default*
 *     - Null
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **blacklistedPropertyNames**
 *     - An array of property names and/or array keys (RegEx) to be filtered. Default is an array of some common property names.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - Array<Integer, String>|Null
 *   * - *Default*
 *     - Null
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
 *   * - **plainText**
 *     - if True, the dump is in plain text, if False the debug output is in HTML format
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
 *   * - **return**
 *     - If True, the dump is returned for custom post-processing (e.g. embed in custom HTML). If False, the dump is directly displayed.
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
 *   * - **title**
 *     - Optional custom title for the debug output
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - String|Null
 *   * - *Default*
 *     - Null
 *
 *Documentation:End
 */
class VarDumpDebuggerModel extends AbstractDebuggerModel {
  public readonly bool $active;

  public readonly bool $ansiColors;

  /** @var array<int, string> */
  public readonly ?array $blacklistedClassNames;

  /** @var array<int, string> */
  public readonly ?array $blacklistedPropertyNames;

  public readonly int $maxDepth;

  public readonly bool $plainText;

  public readonly bool $return;

  public readonly ?string $title;

  /**
   * @param array<string, mixed> $config
   */
  public function __construct(array $config) {
    $this->active = boolval($config['active'] ?? false);
    $this->ansiColors = boolval($config['ansiColors'] ?? true);

    if (isset($config['blacklistedClassNames']) && is_array($config['blacklistedClassNames'])) {
      $this->blacklistedClassNames = $config['blacklistedClassNames'];
    } else {
      // TODO: remove ignore once fixed: https://github.com/phpstan/phpstan/issues/6402
      // @phpstan-ignore-next-line
      $this->blacklistedClassNames = null;
    }

    if (isset($config['blacklistedPropertyNames']) && is_array($config['blacklistedPropertyNames'])) {
      $this->blacklistedPropertyNames = $config['blacklistedPropertyNames'];
    } else {
      // TODO: remove ignore once fixed: https://github.com/phpstan/phpstan/issues/6402
      // @phpstan-ignore-next-line
      $this->blacklistedPropertyNames = null;
    }

    $this->maxDepth = intval($config['maxDepth'] ?? 8);
    $this->plainText = boolval($config['plainText'] ?? false);
    $this->return = boolval($config['return'] ?? false);

    if (isset($config['title'])) {
      $this->title = strval($config['title']);
    } else {
      // TODO: remove ignore once fixed: https://github.com/phpstan/phpstan/issues/6402
      // @phpstan-ignore-next-line
      $this->title = null;
    }
  }

  public function class(): string {
    return VarDumpDebugger::class;
  }
}
