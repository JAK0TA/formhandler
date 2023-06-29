<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Validator;

use Typoheads\Formhandler\Domain\Model\Config\FormModel;
use Typoheads\Formhandler\Domain\Model\Config\Validator\Field\FieldModel;
use Typoheads\Formhandler\Validator\AbstractValidator;

abstract class AbstractValidatorModel {
  /** @var FieldModel[] */
  public array $fields = [];

  /** @var string[] */
  protected array $restrictErrorChecks = [];

  /**
   * @param array<string, mixed> $settings
   */
  abstract public function __construct(FormModel &$formConfig, array $settings);

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
