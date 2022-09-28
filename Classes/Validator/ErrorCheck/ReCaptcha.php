<?php

// Copyright JAKOTA Design Group GmbH. All rights reserved.
declare(strict_types=1);

namespace Typoheads\Formhandler\Validator\ErrorCheck;

use ReCaptcha\ReCaptcha as GoogleRecaptcha;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Validates a ReCaptcha token.
 */
class ReCaptcha extends AbstractErrorCheck {
  private string $expectedAction = 'submit';

  private float $scoreThreshold = 0.6;

  public function check(): string {
    if (!class_exists(\ReCaptcha\ReCaptcha::class) || !class_exists(\ReCaptcha\Response::class)) {
      return $this->getCheckFailed();
    }

    $extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('formhandler');
    if (is_array($extensionConfiguration) && is_array($extensionConfiguration['recaptcha'])) {
      $privkey = $extensionConfiguration['recaptcha']['privatekey'];
    } else {
      return $this->getCheckFailed();
    }

    // recaptcha field does not exist
    if (!isset($this->gp['ReCaptcha'])) {
      return $this->getCheckFailed();
    }

    $recapcha = GeneralUtility::makeInstance(GoogleRecaptcha::class, $privkey);

    /** @var array<string, mixed> $params */
    $params = $this->settings['params'] ?? [];
    $this->expectedAction = $this->utilityFuncs->getSingle($params, 'action') ?: $this->expectedAction;
    $this->scoreThreshold = floatval($this->utilityFuncs->getSingle($params, 'threshold')) ?: $this->scoreThreshold;

    $resp = $recapcha->setExpectedAction($this->expectedAction)->setScoreThreshold($this->scoreThreshold)->verify(strval($this->gp['ReCaptcha']));

    if (!$resp->isSuccess()) {
      return $this->getCheckFailed();
    }

    return '';
  }

  /**
   * @param array<string, mixed> $gp
   * @param array<string, mixed> $settings
   */
  public function init(array $gp, array $settings): void {
    parent::init($gp, $settings);
  }
}
