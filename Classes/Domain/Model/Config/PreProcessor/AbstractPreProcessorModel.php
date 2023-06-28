<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\PreProcessor;

use Typoheads\Formhandler\PreProcessor\AbstractPreProcessor;

abstract class AbstractPreProcessorModel {
  /**
   * @param array<string, mixed> $settings
   */
  abstract public function __construct(array $settings);

  /**
   * @return class-string<AbstractPreProcessor>
   */
  abstract public function class(): string;
}
