<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\Session;

use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Typoheads\Formhandler\Definitions\FormhandlerExtensionConfig;
use Typoheads\Formhandler\Utility\Utility;

class Typo3Session extends AbstractSession {
  private string $cacheIdentifier;

  /** @var array<string, mixed> */
  private array $data = [];

  private string $randomIdIdentifier;

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
    if ($this->started) {
      $this->data = [];
      $this->cache->remove($this->cacheIdentifier);
      $this->cache->remove($this->randomIdIdentifier);

      $this->started = false;
    }

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
    if ($this->started) {
      // TODO: Report Error
      return $this;
    }

    $this->randomIdIdentifier = FormhandlerExtensionConfig::EXTENSION_PLUGIN_SIGNATURE.'_'.$this->formConfig->formId.'_randomId';

    if (empty($this->formConfig->randomId)) {
      $randomId = $this->cache->get($this->randomIdIdentifier);
      if (is_string($randomId) && !empty($randomId)) {
        $this->formConfig->firstAccess = false;
        $this->formConfig->randomId = $randomId;
      } else {
        $this->formConfig->randomId = GeneralUtility::makeInstance(Utility::class)::generateRandomId($this->formConfig);
        $this->cache->set($this->randomIdIdentifier, $this->formConfig->randomId, [], $this->getLifetime());
      }
    } else {
      $this->formConfig->firstAccess = false;
    }

    $this->formConfig->debugMessage(
      key: 'Session started: %s',
      printfArgs: [$this->formConfig->randomId]
    );

    $this->cacheIdentifier = FormhandlerExtensionConfig::EXTENSION_PLUGIN_SIGNATURE.'_'.$this->formConfig->randomId;
    $data = $this->cache->get($this->cacheIdentifier);

    if (is_array($data)) {
      $this->data = $data;
      $this->formConfig->debugMessage(
        key: 'Session data for: %s',
        printfArgs: [$this->formConfig->randomId],
        data: $data,
      );
    }
    $this->started = true;

    return $this;
  }

  protected function getLifetime(): int {
    return 3600;
  }
}
