<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Cache\Backend\SimpleFileBackend;
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

  // Cache registration
  $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['formhandler_cache'] ??= [];
  $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['formhandler_cache']['backend'] ??= SimpleFileBackend::class;

  $GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['excludedParameters'][] = FormhandlerExtensionConfig::EXTENSION_KEY.'[randomId]';
  $GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['excludedParameters'][] = FormhandlerExtensionConfig::EXTENSION_KEY.'[step]';

  // Register "formhandler:" namespace
  $GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['formhandler'][] = 'Typoheads\\Formhandler\\ViewHelpers';
});
