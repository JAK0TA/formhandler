<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Json;

class JsonResponseModel {
  public string $formId = '';

  public string $formName = '';

  public string $formUrl = '';

  public string $formValuesPrefix = '';

  public int $redirectCode = 0;

  public string $redirectPage = '';

  public string $requiredFields = '';

  public int $step = 1;

  /** @var array<int, mixed> */
  public array $steps = [];

  public bool $success = false;
}
