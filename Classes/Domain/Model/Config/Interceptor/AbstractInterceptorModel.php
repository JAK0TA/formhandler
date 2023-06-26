<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Interceptor;

use Typoheads\Formhandler\Interceptor\AbstractInterceptor;

abstract class AbstractInterceptorModel {
  /** @var class-string<AbstractInterceptor> */
  public string $class;

  /**
   * @param array<string, mixed> $settings
   */
  abstract public function __construct(array $settings);
}
