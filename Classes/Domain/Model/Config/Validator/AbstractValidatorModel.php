<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Validator;

use Typoheads\Formhandler\Domain\Model\Config\Validator\Field\FieldModel;
use Typoheads\Formhandler\Validator\AbstractValidator;

abstract class AbstractValidatorModel {
  /** @var array<string, string[]> */
  public array $disableErrorCheckFields = [];

  /** @var FieldModel[] */
  public array $fields = [];

  public int $messageLimit = 0;

  /** @var array<string, int> */
  public array $messageLimits = [];

  /** @var string[] */
  protected array $restrictErrorChecks = [];

  /**
   * @param array<string, mixed> $settings
   */
  abstract public function __construct(array $settings);

  /**
   * @return class-string<AbstractValidator>
   */
  abstract public function class(): string;

  /**
   * @return string[]
   */
  public function restrictErrorChecks(): array {
    return $this->restrictErrorChecks;
  }
}
