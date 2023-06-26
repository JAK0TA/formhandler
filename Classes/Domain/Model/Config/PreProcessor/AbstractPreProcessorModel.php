<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\PreProcessor;

use Typoheads\Formhandler\PreProcessor\AbstractPreProcessor;

abstract class AbstractPreProcessorModel {
  /** @var class-string<AbstractPreProcessor> */
  public string $class;

  /**
   * @param array<string, mixed> $settings
   */
  abstract public function __construct(array $settings);
}
