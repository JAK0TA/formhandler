<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model;

class Log extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {
  protected int $formPageId = 0;

  protected string $ip = '';

  protected bool $isSpam = false;

  protected string $keyHash = '';

  protected string $params = '';

  protected string $uniqueHash = '';

  public function getFormPageId(): int {
    return $this->formPageId;
  }

  public function getIp(): string {
    return $this->ip;
  }

  public function getIsSpam(): bool {
    return $this->isSpam;
  }

  public function getKeyHash(): string {
    return $this->keyHash;
  }

  public function getParams(): string {
    return $this->params;
  }

  public function getUniqueHash(): string {
    return $this->uniqueHash;
  }

  public function setFormPageId(int $formPageId): void {
    $this->formPageId = $formPageId;
  }

  public function setIp(string $ip): void {
    $this->ip = $ip;
  }

  public function setIsSpam(bool $isSpam): void {
    $this->isSpam = $isSpam;
  }

  public function setKeyHash(string $keyHash): void {
    $this->keyHash = $keyHash;
  }

  public function setParams(string $params): void {
    $this->params = $params;
  }

  public function setUniqueHash(string $uniqueHash): void {
    $this->uniqueHash = $uniqueHash;
  }
}
