<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Validator;

abstract class AbstractValidator {
  public string $class = '';

  /** @var array<string, string[]> */
  public array $disableErrorCheckFields = [];

  /** @var Field[] */
  public array $fields = [];

  public int $messageLimit = 0;

  /** @var array<string, int> */
  public array $messageLimits = [];

  /** @var string[] */
  public array $restrictErrorChecks = [];

  /**
   * @param array<string, mixed> $settings
   */
  abstract public function __construct(array $settings = []);
}
