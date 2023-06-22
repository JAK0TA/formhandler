<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use Typoheads\Formhandler\Definitions\FormhandlerExtensionConfig;

defined('TYPO3') or exit;

ExtensionManagementUtility::addStaticFile(
  FormhandlerExtensionConfig::EXTENSION_KEY,
  'Configuration/TypoScript',
  FormhandlerExtensionConfig::EXTENSION_TITLE
);
