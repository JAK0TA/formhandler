<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Session;

use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;

class Typo3Session extends AbstractSession {
  private string $cacheIdentifier;

  /** @var array<string, mixed> */
  private array $data = [];

  public function __construct(
    private readonly FrontendInterface $cache,
  ) {
  }

  public function exists(): bool {
    if (!$this->started) {
      // TODO: Report Error
      return false;
    }

    return !empty($this->data);
  }

  public function get(string $key): mixed {
    if (!$this->started) {
      // TODO: Report Error
      return null;
    }

    return $this->data[$key] ?? null;
  }

  public function reset(): Typo3Session {
    $this->data = [];
    $this->cache->remove($this->cacheIdentifier);

    return $this;
  }

  public function set(string $key, mixed $value): Typo3Session {
    if (!$this->started) {
      // TODO: Report Error
      return $this;
    }

    $this->data[$key] = $value;

    $this->cache->set($this->cacheIdentifier, $this->data, [], $this->getLifetime());

    return $this;
  }

  /**
   * @param array<string, mixed> $values
   */
  public function setMultiple(array $values): Typo3Session {
    if (!$this->started) {
      // TODO: Report Error
      return $this;
    }
    foreach ($values as $key => $value) {
      $this->data[$key] = $value;
    }
    $this->cache->set($this->cacheIdentifier, $this->data, [], $this->getLifetime());

    return $this;
  }

  public function start(): Typo3Session {
    if (!isset($this->formConfig)) {
      // TODO: Report Error
      return $this;
    }

    if ($this->started) {
      // TODO: Report Error
      return $this;
    }

    $this->cacheIdentifier = 'formhandler_'.$this->formConfig->randomId;
    $data = $this->cache->get($this->cacheIdentifier);
    if (is_array($data)) {
      $this->data = $data;
    }
    $this->started = true;

    return $this;
  }

  protected function getLifetime(): int {
    return 3600;
  }
}
