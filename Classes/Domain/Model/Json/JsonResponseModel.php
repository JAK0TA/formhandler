<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\Domain\Model\Json;

use Typoheads\Formhandler\Domain\Model\Config\FormUpload;
use Typoheads\Formhandler\Domain\Model\Config\GeneralOptions\FieldSetModel;
use Typoheads\Formhandler\Domain\Model\Config\GeneralOptions\FileUploadModel;
use Typoheads\Formhandler\Domain\Model\Config\GeneralOptions\SelectOptionModel;

class JsonResponseModel {
  public string $extensionKey = '';

  /** @var array<string, string[]> */
  public array $fieldsErrors = [];

  /** @var FieldSetModel[] */
  public array $fieldSets = [];

  public FileUploadModel $fileUpload;

  public string $formId = '';

  public string $formName = '';

  public FormUpload $formUploads;

  public string $formUrl = '';

  /** @var array<string, mixed> */
  public array $formValues;

  public string $formValuesPrefix = '';

  public int $redirectCode = 0;

  public string $redirectPage = '';

  public string $requiredFields = '';

  public string $returnFinisher = '';

  /** @var array<string, SelectOptionModel[]> */
  public array $selectsOptions = [];

  public int $step = 1;

  /** @var array<int, mixed> */
  public array $steps = [];

  public bool $success = false;
}
