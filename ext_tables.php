<?php

use TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider;
use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use Typoheads\Formhandler\Controller\ModuleController;

if (!defined('TYPO3')) {
  exit('Access denied.');
}
ExtensionUtility::registerModule(
  'Formhandler',
  'web',
  'log',
  'bottom',
  [
    ModuleController::class => 'index, view, selectFields, export',
  ],
  [
    'access' => 'user,group',
    'icon' => 'EXT:formhandler/Resources/Public/Icons/ModuleIcon.png',
    'labels' => 'LLL:EXT:formhandler/Resources/Private/Language/locallang_mod.xlf',
  ]
);
ExtensionManagementUtility::allowTableOnStandardPages('tx_formhandler_log');
// REGISTER ICONS FOR USE IN BACKEND WIZARD
GeneralUtility::makeInstance(IconRegistry::class)->registerIcon(
  'formhandlerElement',
  BitmapIconProvider::class,
  ['source' => 'EXT:formhandler/Resources/Public/Icons/Extension.png']
);
