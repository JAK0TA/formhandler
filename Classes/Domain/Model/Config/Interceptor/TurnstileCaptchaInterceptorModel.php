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

use Typoheads\Formhandler\Interceptor\TurnstileCaptchaInterceptor;

class TurnstileCaptchaInterceptorModel extends AbstractInterceptorModel {
  public function __construct(array $settings) {}

  public function class(): string {
    return TurnstileCaptchaInterceptor::class;
  }
}
