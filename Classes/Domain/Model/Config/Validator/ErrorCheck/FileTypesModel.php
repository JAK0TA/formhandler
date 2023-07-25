<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck;

use Symfony\Component\Mime\MimeTypes;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Typoheads\Formhandler\Validator\ErrorCheck\FileTypes;

/** Documentation:Start:ErrorChecks/FileUpload/FileTypes.rst.
 *
 *.. _filetypes:
 *
 *=========
 *FileTypes
 *=========
 *
 *Checks if the file type of an uploaded file is allowed.
 *
 *..  code-block:: typoscript
 *
 *    Example Code:
 *
 *    validators {
 *      DefaultValidator {
 *        model = DefaultValidator
 *        config {
 *          fields {
 *            image.errorChecks {
 *              fileTypes {
 *                model = FileTypes
 *                fileTypes = .jpg,.gif,.png,image/*
 *              }
 *            }
 *          }
 *        }
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
 *   * - **fileTypes**
 *     - | Comma separated list containing one or more of these unique file type specifiers.
 *       |
 *       | A valid case-insensitive filename extension, starting with a period (".") character. For example: .jpg, .pdf, or .doc.
 *       |
 *       | A valid MIME type string, with no extensions.
 *       | The string audio/* meaning "any audio file".
 *       | The string video/* meaning "any video file".
 *       | The string image/* meaning "any image file".
 *   * -
 *     -
 *   * - *Mandatory*
 *     - False
 *   * - *Data Type*
 *     - String
 *   * - *Default*
 *     - Empty String
 *
 *.. toctree::
 *   :maxdepth: 2
 *   :hidden:
 *
 *Documentation:End
 */
class FileTypesModel extends AbstractErrorCheckModel {
  /** @var string[] */
  public readonly array $fileTypes;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'FileTypes';

    $mimes = new MimeTypes();

    $fileTypes = GeneralUtility::trimExplode(',', strval($settings['fileTypes'] ?? ''), true);
    foreach ($fileTypes as $key => &$fileType) {
      if ('.' == $fileType[0]) {
        $ext = substr($fileType, 1);
        unset($fileTypes[$key]);
        array_push($fileTypes, ...$mimes->getMimeTypes($ext));
      } elseif ('/*' == substr($fileType, -2)) {
        $fileType = substr($fileType, 0, -1);
      }
    }
    $this->fileTypes = $fileTypes;
  }

  public function class(): string {
    return FileTypes::class;
  }
}
