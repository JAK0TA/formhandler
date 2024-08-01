<?php

declare(strict_types=1);

use Typoheads\Formhandler\Controller\AdministrationController;
use Typoheads\Formhandler\Definitions\FormhandlerExtensionConfig;

return [
  'web_formhandler' => [
    'parent' => 'web',
    'access' => 'user',
    'iconIdentifier' => 'formhandler',
    'labels' => 'LLL:EXT:formhandler/Resources/Private/Language/locallang_mod.xlf',
    'extensionName' => FormhandlerExtensionConfig::EXTENSION_TITLE,
    'controllerActions' => [
      AdministrationController::class => [
        'index',
      ],
    ],
    'inheritNavigationComponentFromMainModule' => false,
    'navigationComponent' => '',
  ],
];
