<?php

declare(strict_types=1);

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use Typoheads\Formhandler\Controller\FormController;
use Typoheads\Formhandler\Definitions\FormhandlerExtensionConfig;

defined('TYPO3') or exit;

call_user_func(static function (): void {
  ExtensionUtility::configurePlugin(
    FormhandlerExtensionConfig::EXTENSION_KEY,
    FormhandlerExtensionConfig::EXTENSION_PLUGIN_NAME,
    [
      FormController::class => 'form',
    ],
    [
      FormController::class => 'form',
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
  );
});
