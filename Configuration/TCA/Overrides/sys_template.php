<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use Typoheads\Formhandler\Definitions\FormhandlerExtensionConfig;

defined('TYPO3') or exit;

call_user_func(static function (): void {
  ExtensionManagementUtility::addStaticFile(
    FormhandlerExtensionConfig::EXTENSION_KEY,
    'Configuration/TypoScript',
    FormhandlerExtensionConfig::EXTENSION_TITLE
  );
});
