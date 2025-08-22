<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\Domain\Model\Config\Interceptor;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Typoheads\Formhandler\Interceptor\EmailOverrideInterceptor;

class EmailOverrideInterceptorModel extends AbstractInterceptorModel {
  /** @var array<EmailOverrideInterceptorConditionBlock> */
  public readonly array $conditonBlocks;

  /**
   * @param array<mixed> $settings
   */
  public function __construct(array $settings) {
    $this->conditonBlocks = $this->parseConfig($settings);
  }

  public function class(): string {
    return EmailOverrideInterceptor::class;
  }

  /**
   * @param array<mixed> $settings
   *
   * @return array<EmailOverrideInterceptorConditionBlock>
   */
  protected function parseConfig(array $settings): array {
    if (!is_array($settings)) {
      return [];
    }

    $conditionBlocks = [];

    foreach ($settings as $conditionBlock) {
      if (!isset($conditionBlock['conditions']) || (!isset($conditionBlock['isTrue']) && !isset($conditionBlock['else']))) {
        continue;
      }

      $conditionBlocks[] = GeneralUtility::makeInstance(EmailOverrideInterceptorConditionBlock::class, $conditionBlock);
    }

    return $conditionBlocks;
  }
}
