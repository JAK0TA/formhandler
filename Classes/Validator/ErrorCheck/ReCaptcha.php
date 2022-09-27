<?php

// Copyright JAKOTA Design Group GmbH. All rights reserved.
declare(strict_types=1);

namespace Typoheads\Formhandler\Validator\ErrorCheck;

use ReCaptcha\ReCaptcha as GoogleRecaptcha;
use ReCaptcha\Response;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * Validates a ReCaptcha token.
 */
class ReCaptcha extends AbstractErrorCheck {
  private string $expectedAction = 'submit';

  private float $scoreThreshold = 0.6;

  public function check(): string {
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
    $params = $this->settings['params'];
    $this->expectedAction = $this->utilityFuncs->getSingle($params, 'action') ?: $this->expectedAction;
    $this->scoreThreshold = $this->utilityFuncs->getSingle($params, 'threshold') ?: $this->scoreThreshold;

    DebuggerUtility::var_dump($this->expectedAction);

    /** @var Response $resp */
    $resp = $recapcha->setExpectedAction($this->expectedAction)->setScoreThreshold($this->scoreThreshold)->verify(strval($this->gp['ReCaptcha']));

    DebuggerUtility::var_dump($resp);
    DebuggerUtility::var_dump($this->gp);
    DebuggerUtility::var_dump($this->gp['ReCaptcha']);

    exit;

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
