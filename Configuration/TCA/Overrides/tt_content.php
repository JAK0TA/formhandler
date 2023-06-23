<?php

use Typoheads\Formhandler\Definitions\FormhandlerExtensionConfig;

defined('TYPO3') or exit;

call_user_func(static function (): void {
  $contentTypeName = \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    FormhandlerExtensionConfig::EXTENSION_KEY,
    FormhandlerExtensionConfig::EXTENSION_PLUGIN_NAME,
    'LLL:EXT:'.FormhandlerExtensionConfig::EXTENSION_KEY.'/Resources/Private/Language/locallang_mod.xlf:mlang_labels_tablabel',
    'formhandler',
    'forms'
  );

  // Add the FlexForm
  \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:'.FormhandlerExtensionConfig::EXTENSION_KEY.'/Configuration/FlexForms/Form.xml',
    $contentTypeName
  );

  // Add the FlexForm to the show item list
  \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.plugin, pi_flexform',
    $contentTypeName,
    'after:palette:headers'
  );
});
