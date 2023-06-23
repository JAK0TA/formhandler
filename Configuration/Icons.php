<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;
use Typoheads\Formhandler\Definitions\FormhandlerExtensionConfig;

return [
  'module-formhandler' => [
    'provider' => SvgIconProvider::class,
    'source' => 'EXT:'.FormhandlerExtensionConfig::EXTENSION_KEY.'/Resources/Public/Icons/Extension.svg',
  ],
  'content-formhandler' => [
    'provider' => SvgIconProvider::class,
    'source' => 'EXT:'.FormhandlerExtensionConfig::EXTENSION_KEY.'/Resources/Public/Icons/Extension.svg',
  ],
];
