<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\Interceptor;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Typoheads\Formhandler\Definitions\Severity;
use Typoheads\Formhandler\Domain\Model\Config\Finisher\MailFinisherModel;
use Typoheads\Formhandler\Domain\Model\Config\FormModel;
use Typoheads\Formhandler\Domain\Model\Config\Interceptor\AbstractInterceptorModel;
use Typoheads\Formhandler\Domain\Model\Config\Interceptor\EmailOverrideInterceptorModel;
use Typoheads\Formhandler\Utility\Utility;

class EmailOverrideInterceptor extends AbstractInterceptor implements LoggerAwareInterface {
  use LoggerAwareTrait;

  protected array $adminMailConfig;

  protected bool $returns;

  protected array $userMailConfig;

  protected Utility $utility;

  public function __construct() {
    $this->utility = GeneralUtility::makeInstance(Utility::class);
  }

  public function process(FormModel &$formConfig, AbstractInterceptorModel &$interceptorConfig): bool {
    if (!$interceptorConfig instanceof EmailOverrideInterceptorModel) {
      return false;
    }

    /**
     * find finisher config by Classname.
     *
     * @var array<int, MailFinisherModel> $allMailFinisherConfigs
     */
    $allMailFinisherConfigs = array_filter($formConfig->finishers, function ($finisher) {
      return $finisher instanceof MailFinisherModel;
    }) ?? false;

    if (false === $allMailFinisherConfigs) {
      return false;
    }

    $currentFinisherConfig = current($allMailFinisherConfigs);

    $this->adminMailConfig = $currentFinisherConfig->adminMailConfig;
    $this->userMailConfig = $currentFinisherConfig->userMailConfig;
    $this->returns = $currentFinisherConfig->returns;

    try {
      foreach ($interceptorConfig->conditonBlocks as $conditionBlock) {
        $evaluation = $this->utility->conditionEvaluate($conditionBlock, $formConfig);

        if ($evaluation) {
          foreach ($conditionBlock->isTrue as $emailConfigToAffect => $valuesToSet) {
            if (empty($valuesToSet) || ('admin' !== $emailConfigToAffect && 'user' !== $emailConfigToAffect)) {
              continue;
            }

            $this->handleOverride($emailConfigToAffect, $valuesToSet);
          }
        } else {
          foreach ($conditionBlock->else as $emailConfigToAffect => $valuesToSet) {
            if (empty($valuesToSet) || ('admin' !== $emailConfigToAffect && 'user' !== $emailConfigToAffect)) {
              continue;
            }

            $this->handleOverride($emailConfigToAffect, $valuesToSet);
          }
        }
      }

      // results from array_filter keep their original keys. Use that key to override the config
      $formConfig->finishers[key($allMailFinisherConfigs)] = $this->createNewMailConfig();
    } catch (\Exception $e) {
      $this->logger->error($e->getMessage());

      $formConfig->debugMessage('Mailfinisher Error', [$e->getMessage()], Severity::Error);

      return false;
    }

    return true;
  }

  protected function createNewMailConfig() {
    return GeneralUtility::makeInstance(
      MailFinisherModel::class,
      ['returns' => $this->returns],
      $this->adminMailConfig,
      $this->userMailConfig,
    );
  }

  protected function handleOverride(string $configToAffect, $overrideConfig) {
    $configToAffect = &$this->{$configToAffect.'MailConfig'} ?? false;

    if (false === $configToAffect) {
      return;
    }

    foreach ($overrideConfig as $fieldToOverride => $valueToSet) {
      if (array_key_exists($fieldToOverride, $configToAffect)) {
        $configToAffect[$fieldToOverride] = strval($valueToSet);
      }
    }
  }
}
