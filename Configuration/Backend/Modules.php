<?php

declare(strict_types=1);

use Typoheads\Formhandler\Controller\AdministrationController;
use Typoheads\Formhandler\Definitions\FormhandlerExtensionConfig;

return [
  'web_formhandler' => [
    'parent' => 'web',
    'access' => 'user',
    'iconIdentifier' => 'module-formhandler',
    'labels' => 'LLL:EXT:formhandler/Resources/Private/Language/locallang_mod.xlf',
    'extensionName' => FormhandlerExtensionConfig::EXTENSION_TITLE,
    'controllerActions' => [
      AdministrationController::class => [
        'index',
      ],
    ],
    // 'inheritNavigationComponentFromMainModule' => false,
    // 'navigationComponent' => '@typo3/backend/page-tree/page-tree-element-2',
  ],
];
