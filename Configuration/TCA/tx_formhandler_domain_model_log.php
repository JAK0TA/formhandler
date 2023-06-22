<?php

declare(strict_types=1);

return [
  'ctrl' => [
    'title' => 'LLL:EXT:formhandler/Resources/Private/Language/locallang_db.xlf:tx_formhandler_domain_model_log',
    'label' => 'form_page_id',
    'label_alt' => 'ip, crdate',
    'tstamp' => 'tstamp',
    'crdate' => 'crdate',
    'sortby' => 'crdate',
    'versioningWS' => false,
    'security' => [
      'ignoreWebMountRestriction' => true,
      'ignorePageTypeRestriction' => true,
    ],
    'delete' => 'deleted',
    'enablecolumns' => [
      'disabled' => 'hidden',
    ],
    'iconfile' => 'EXT:formhandler/Resources/Public/Icons/tx_formhandler_domain_model_log.svg',
    'hideTable' => false,
    'searchFields' => 'form_page_id, ip',
  ],
  'types' => [
    '0' => [
      'showitem' => ' 
        form_page_id, ip,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden
      ',
    ],
  ],
  'columns' => [
    'hidden' => [
      'exclude' => true,
      'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
      'config' => [
        'type' => 'check',
        'renderType' => 'checkboxToggle',
        'items' => [
          [
            0 => '',
            1 => '',
            'invertStateDisplay' => true,
          ],
        ],
      ],
    ],
    'form_page_id' => [
      'label' => 'LLL:EXT:formhandler/Resources/Private/Language/locallang_db.xlf:form_page_id',
      'config' => [
        'type' => 'input',
        'readOnly' => true,
      ],
    ],
    'ip' => [
      'label' => 'LLL:EXT:formhandler/Resources/Private/Language/locallang_db.xlf:ip',
      'config' => [
        'type' => 'input',
        'readOnly' => true,
      ],
    ],
  ],
];
