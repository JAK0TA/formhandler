<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Session;

use TYPO3\CMS\Core\SingletonInterface;
use Typoheads\Formhandler\Domain\Model\Config\FormModel;

abstract class AbstractSession implements SingletonInterface {
  protected FormModel $formConfig;

  protected bool $started = false;

  abstract public function exists(): bool;

  abstract public function get(string $key): mixed;

  public function init(FormModel &$formConfig): AbstractSession {
    $this->formConfig = $formConfig;

    return $this;
  }

  abstract public function reset(): AbstractSession;

  abstract public function set(string $key, mixed $value): AbstractSession;

  /**
   * @param array<string, mixed> $values
   */
  abstract public function setMultiple(array $values): AbstractSession;

  abstract public function start(): AbstractSession;

  abstract protected function getLifetime(): int;
}
