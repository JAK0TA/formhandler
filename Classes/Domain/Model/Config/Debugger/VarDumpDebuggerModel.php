<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Debugger;

use Typoheads\Formhandler\Debugger\VarDumpDebugger;

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
