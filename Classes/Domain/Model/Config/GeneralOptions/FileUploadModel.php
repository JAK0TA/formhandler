<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\Domain\Model\Config\GeneralOptions;

/** Documentation:Start:GeneralOptions/FileUpload.rst.
 *
 *.. _fileupload:
 *
 *==========
 *FileUpload
 *==========
 *
 *Settings to handle file uploads.
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **TypoScript Path**
 *     - plugin.tx_formhandler_form.settings.predefinedForms.[x].fileUpload
 *
 *..  code-block::
 *
 *    Example Code:
 *
 *    plugin.tx_formhandler_form.settings.predefinedForms.devExample {
 *      fileUpload {
 *        nameCleanUp {
 *          search = /[^A-Za-z0-9_.-]/
 *          separator =
 *          replace =
 *          usePregReplace = true
 *        }
 *        removal {
 *          active = true
 *          text = X
 *        }
 *        total {
 *          countMax =
 *          sizeMax =
 *        }
 *        withSameName = ignore
 *      }
 *    }
 *
 ***Properties**
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **nameCleanUp.search**
 *     - Separated list of characters or regex to replace in file names of uploaded files.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - String
 *   * - *Default*
 *     - Space character and %20
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **nameCleanUp.separator**
 *     - Custom separator for several search patterns.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - String
 *   * - *Default*
 *     - ,
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **nameCleanUp.replace**
 *     - Separated list of characters to use as a replacement for the characters or regex configured in nameCleanUp.search.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - String
 *   * - *Default*
 *     - _
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **nameCleanUp.usePregReplace**
 *     - If True, uses preg_replace to search and replace string in a filename in favor of a simple str_replace.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - Boolean
 *   * - *Default*
 *     - False
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **removal.active**
 *     - | If True, enables file removal without using an AjaxHandler.
 *       | This will just display an “X” or anything entered in removal.text next to a file name of an uploaded file, so the user can remove it.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - Boolean
 *   * - *Default*
 *     - False
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **removal.text**
 *     - Enter a custom text shown as the text of the remove link. Used in combination with removal.active.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - String
 *   * - *Default*
 *     - X
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **total.countMax**
 *     - The total amount of files allowed for upload.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - False|Integer
 *   * - *Default*
 *     - False
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **total.sizeMax**
 *     - The size of all uploaded file allowed for upload. (in Byte)
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - False|Integer
 *   * - *Default*
 *     - False
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **withSameName**
 *     - | Specify how to deal with files with the same name being uploaded.
 *       |
 *       | The possible values are:
 *       | ignore => Files with the same name are ignored.
 *       | replace => Files with the same name replace the existing ones.
 *       | append => Files with the same name are appended to the list of uploaded files.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - String
 *   * - *Default*
 *     - ignore
 *
 *Documentation:End
 */
class FileUploadModel {
  /** @var string[] */
  public readonly array $nameCleanUpReplace;

  /** @var string[] */
  public readonly array $nameCleanUpSearch;

  public readonly bool $nameCleanUpUsePregReplace;

  public readonly bool $removalActive;

  public readonly string $removalText;

  public readonly false|int $totalCountMax;

  public readonly false|int $totalSizeMax;

  public readonly string $withSameName;

  /**
   * @param array<string, mixed> $config
   */
  public function __construct(array $config) {
    if (isset($config['nameCleanUp']) && is_array($config['nameCleanUp'])) {
      $separator = strval($config['nameCleanUp']['separator'] ?? '');
      $separator = empty($separator) ? ',' : $separator;
      $this->nameCleanUpSearch = explode($separator, strval($config['nameCleanUp']['search'] ?? ' ,%20'));
      $this->nameCleanUpReplace = explode($separator, strval($config['nameCleanUp']['replace'] ?? '_'));
      $this->nameCleanUpUsePregReplace = filter_var($config['nameCleanUp']['usePregReplace'] ?? false, FILTER_VALIDATE_BOOLEAN);
    } else {
      $this->nameCleanUpSearch = [' ', '%20'];
      $this->nameCleanUpReplace = ['_'];
      $this->nameCleanUpUsePregReplace = false;
    }

    if (isset($config['removal']) && is_array($config['removal'])) {
      $this->removalActive = filter_var($config['removal']['active'] ?? false, FILTER_VALIDATE_BOOLEAN);
      $this->removalText = strval($config['removal']['text'] ?? 'X');
    } else {
      $this->removalActive = false;
      $this->removalText = 'X';
    }

    if (isset($config['total']) && is_array($config['total'])) {
      $this->totalCountMax = filter_var($config['total']['countMax'] ?? 0, FILTER_VALIDATE_INT);
      $this->totalSizeMax = filter_var($config['total']['sizeMax'] ?? 0, FILTER_VALIDATE_INT);
    } else {
      $this->totalCountMax = false;
      $this->totalSizeMax = false;
    }

    if (isset($config['withSameName'])) {
      $withSameName = strval($config['withSameName']);
      $this->withSameName = !in_array($withSameName, ['ignore', 'replace', 'append']) ?
        'ignore' :
        $withSameName;
    } else {
      $this->withSameName = 'ignore';
    }
  }
}
