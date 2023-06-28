<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Interceptor;

use Typoheads\Formhandler\Interceptor\AbstractInterceptor;

abstract class AbstractInterceptorModel {
  /**
   * @param array<string, mixed> $settings
   */
  abstract public function __construct(array $settings);

  /**
   * @return class-string<AbstractInterceptor>
   */
  abstract public function class(): string;
}
