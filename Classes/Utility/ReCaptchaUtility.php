<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Utility;

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This script is part of the TYPO3 project - inspiring people to share!
 *
 * TYPO3 is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 2 as published by
 * the Free Software Foundation.
 *
 * This script is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General
 * Public License for more details.
 */

/**
 * A PDF Template class for Formhandler generated PDF files for usage with Generator_TCPDF.
 */
class ReCaptchaUtility implements SingletonInterface {
  public function makeCaptcha(): string {
    $extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('formhandler');
    if (is_array($extensionConfiguration) && is_array($extensionConfiguration['recaptcha']) && !empty($extensionConfiguration['recaptcha']['sitekey'])) {
      $sitekey = $extensionConfiguration['recaptcha']['sitekey'];
      $this->addJs($sitekey);

      return '<input name="formhandler[ReCaptcha]" type="hidden" id="ReCaptchaField" data-siteKey="'.$sitekey.'" />';
    }

    return '';
  }

  private function addJs(string $sitekey) {
    $GLOBALS['TSFE']->additionalHeaderData[] = '<script type="module" src="/typo3conf/ext/formhandler/Resources/Public/JavaScript/ReCaptcha.js"></script>';
  }
}
