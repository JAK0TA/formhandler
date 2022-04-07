<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Generator;

use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
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
 * PDF generator class for Formhandler using the extension "webkitpdf".
 */
class WebkitPdf extends AbstractGenerator {
  /* (non-PHPdoc)
   * @see Classes/Generator/Tx_Formhandler_AbstractGenerator#getLink($linkGP)
  */
  public function getLink(array $linkGP = []): string {
    $params = $this->getDefaultLinkParams();
    $componentParams = $this->getComponentLinkParams($linkGP);
    if (is_array($componentParams)) {
      $params = $this->utilityFuncs->mergeConfiguration($params, $componentParams);
    }
    $text = $this->getLinkText();
    $this->url = GeneralUtility::getIndpEnv('TYPO3_SITE_URL').$this->cObj->getTypolink_URL($GLOBALS['TSFE']->id, $params);
    $params = [
      'tx_webkitpdf_pi1' => [
        'urls' => [
          $this->url,
        ],
      ],
      'no_cache' => 1,
    ];

    return $this->cObj->getTypolink($text, $this->settings['pid'], $params);
  }

  /**
   * Renders the PDF.
   *
   * @return mixed
   */
  public function process(): array {
    if (ExtensionManagementUtility::isLoaded('webkitpdf')) {
      $linkGP = [];
      if (strlen($this->globals->getFormValuesPrefix()) > 0) {
        $linkGP[$this->globals->getFormValuesPrefix()] = $this->gp;
      } else {
        $linkGP = $this->gp;
      }

      $url = GeneralUtility::getIndpEnv('TYPO3_SITE_URL').$this->cObj->getTypolink_URL($GLOBALS['TSFE']->id, $linkGP);
      if ($this->url) {
        $url = $this->url;
      }
      $config = $this->readWebkitPdfConf();
      $config['fileOnly'] = 1;
      $config['urls.'] = $url;
      if (!class_exists('tx_webkitpdf_pi1')) {
        require_once ExtensionManagementUtility::extPath('webkitpdf').'pi1/class.tx_webkitpdf_pi1.php';
      }
      $generator = GeneralUtility::makeInstance('tx_webkitpdf_pi1');
      $generator->cObj = $this->globals->getCObj();

      return $generator->main('', $config);
    }
  }

  /* (non-PHPdoc)
   * @see Classes/Generator/Tx_Formhandler_AbstractGenerator#getComponentLinkParams($linkGP)
  */
  protected function getComponentLinkParams(array $linkGP): array {
    $prefix = $this->globals->getFormValuesPrefix();
    $tempParams = [
      'action' => 'show',
    ];
    $params = [];
    if ($prefix) {
      $params[$prefix] = $tempParams;
    } else {
      $params = $tempParams;
    }

    return $params;
  }

  /* (non-PHPdoc)
   * @see Classes/Generator/Tx_Formhandler_AbstractGenerator#getLinkText()
  */
  protected function getLinkText(): string {
    $config = $this->readWebkitPdfConf();
    $text = $this->utilityFuncs->getSingle($config, 'linkText');
    if (0 === strlen($text)) {
      $text = 'Save as PDF';
    }

    return $text;
  }

  /**
   * Reads the TS configuration of the extension "webkitpdf".
   *
   * @return array $conf
   */
  protected function readWebkitPdfConf(): array {
    $sysPageObj = GeneralUtility::makeInstance(PageRepository::class);

    if (!$GLOBALS['TSFE']->sys_page) {
      $GLOBALS['TSFE']->sys_page = $sysPageObj;
    }

    $rootLine = $sysPageObj->getRootLine($GLOBALS['TSFE']->id);
    $TSObj = GeneralUtility::makeInstance('\TYPO3\CMS\Core\TypoScript\ExtendedTemplateService');
    $TSObj->tt_track = 0;
    $TSObj->init();
    $TSObj->runThroughTemplates($rootLine);
    $TSObj->generateConfig();

    $conf = [];
    if (isset($TSObj->setup['plugin.']['tx_webkitpdf_pi1.'])) {
      $conf = $TSObj->setup['plugin.']['tx_webkitpdf_pi1.'];
    }

    return $conf;
  }
}
