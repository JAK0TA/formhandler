<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config;

class Mail {
  public string $bccEmail = '';

  public string $bccName = '';

  public string $ccEmail = '';

  public string $ccName = '';

  public string $replyToEmail = '';

  public string $replyToName = '';

  public string $senderEmail = '';

  public string $senderName = '';

  public string $subject = '';

  public string $toEmail = '';

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings = []) {
    $this->bccEmail = strval($settings['bccEmail'] ?? '');
    $this->bccName = strval($settings['bccName'] ?? '');
    $this->ccEmail = strval($settings['ccEmail'] ?? '');
    $this->ccName = strval($settings['ccName'] ?? '');
    $this->replyToEmail = strval($settings['replyToEmail'] ?? '');
    $this->replyToName = strval($settings['replyToName'] ?? '');
    $this->senderEmail = strval($settings['senderEmail'] ?? '');
    $this->senderName = strval($settings['senderName'] ?? '');
    $this->subject = strval($settings['subject'] ?? '');
    $this->toEmail = strval($settings['toEmail'] ?? '');
  }
}
