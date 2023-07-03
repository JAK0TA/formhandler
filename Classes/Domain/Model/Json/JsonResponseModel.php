<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Json;

use Typoheads\Formhandler\Domain\Model\Config\FieldSetModel;
use Typoheads\Formhandler\Domain\Model\Config\SelectOptionModel;

class JsonResponseModel {
  /** @var array<string, string[]> */
  public array $fieldsErrors = [];

  /** @var FieldSetModel[] */
  public array $fieldSets = [];

  /** @var array<string, SelectOptionModel[]> */
  public array $fieldsSelectOptions = [];

  public string $formId = '';

  public string $formName = '';

  public string $formUrl = '';

  /** @var array<string, mixed> */
  public array $formValues;

  public string $formValuesPrefix = '';

  public int $redirectCode = 0;

  public string $redirectPage = '';

  public string $requiredFields = '';

  public string $returnFinisher = '';

  public int $step = 1;

  /** @var array<int, mixed> */
  public array $steps = [];

  public bool $success = false;
}
