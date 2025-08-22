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

use Typoheads\Formhandler\Domain\Model\Config\GeneralOptions\ConditionBlockModel;

class EmailOverrideInterceptorConditionBlock extends ConditionBlockModel {
  /** @var array<string, array<string, string>> */
  public readonly array $conditions;

  /** @var array<string, array<string, string>> */
  public readonly array $else;

  /** @var array<string, array<string, string>> */
  public readonly array $isTrue;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->conditions = $settings['conditions'] ?? [];
    $this->else = $settings['else'] ?? [];
    $this->isTrue = $settings['isTrue'] ?? [];
  }
}
