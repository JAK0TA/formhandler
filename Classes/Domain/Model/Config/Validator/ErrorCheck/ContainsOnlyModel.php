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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Typoheads\Formhandler\Validator\ErrorCheck\ContainsOnly;

/** Documentation:Start:ErrorChecks/Strings/ContainsOnly.rst.
 *
 *.. _containsonly:
 *
 *============
 *ContainsOnly
 *============
 *
 *Checks if a field contains only the configured characters.
 *
 *..  code-block:: typoscript
 *
 *    Example Code:
 *
 *    validators {
 *      DefaultValidator {
 *        model = DefaultValidatorModel
 *        config {
 *          fields {
 *            password.errorChecks {
 *              containsOnly {
 *                model = ContainsOnlyModel
 *                characters = a,b,c,d,e,f,g,h,i,j,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,1,2,3,4,5,6,7,8,9,0
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
 *   * - **characters**
 *     - Comma separated list of characters of which can be present the value of a given field
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
class ContainsOnlyModel extends AbstractErrorCheckModel {
  /** @var string[] */
  public readonly array $characters;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = 'ContainsOnly';
    $this->characters = GeneralUtility::trimExplode(',', strval($settings['characters'] ?? ''));
  }

  public function class(): string {
    return ContainsOnly::class;
  }
}
