<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:bss_shop/Resources/Private/Language/locallang_db.xlf:tx_bssshop_domain_model_client',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'searchFields' => 'name,street,zip,city,country,phone',
        'iconfile' => 'EXT:bss_shop/Resources/Public/Icons/tx_bssshop_domain_model_client.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, street, zip, city, country, phone, user',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, street, zip, city, country, phone, user'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ]
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_bssshop_domain_model_client',
                'foreign_table_where' => 'AND {#tx_bssshop_domain_model_client}.{#pid}=###CURRENT_PID### AND {#tx_bssshop_domain_model_client}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
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
                        'invertStateDisplay' => true
                    ]
                ],
            ],
        ],

        'name' => [
            'exclude' => false,
            'label' => 'LLL:EXT:bss_shop/Resources/Private/Language/locallang_db.xlf:tx_bssshop_domain_model_client.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'email' => [
            'exclude' => false,
            'label' => 'LLL:EXT:bss_shop/Resources/Private/Language/locallang_db.xlf:tx_bssshop_domain_model_client.email',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'street' => [
            'exclude' => false,
            'label' => 'LLL:EXT:bss_shop/Resources/Private/Language/locallang_db.xlf:tx_bssshop_domain_model_client.street',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'zip' => [
            'exclude' => false,
            'label' => 'LLL:EXT:bss_shop/Resources/Private/Language/locallang_db.xlf:tx_bssshop_domain_model_client.zip',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'city' => [
            'exclude' => false,
            'label' => 'LLL:EXT:bss_shop/Resources/Private/Language/locallang_db.xlf:tx_bssshop_domain_model_client.city',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],

        'country' => [
            'exclude' => false,
            'label' => 'LLL:EXT:bss_shop/Resources/Private/Language/locallang_db.xlf:tx_bssshop_domain_model_client.country',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'static_countries',
                "foreign_table_where" => " ORDER BY static_countries.cn_short_en",
                'minitems' => 0,
                'maxitems' => 1,
                'appearance' => [
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],
        ],

//        'country' => [
//            'exclude' => false,
//            'label' => 'LLL:EXT:bss_shop/Resources/Private/Language/locallang_db.xlf:tx_bssshop_domain_model_client.country',
//            'config' => [
//                'type' => 'input',
//                'size' => 30,
//                'eval' => 'trim'
//            ],
//        ],
        'phone' => [
            'exclude' => false,
            'label' => 'LLL:EXT:bss_shop/Resources/Private/Language/locallang_db.xlf:tx_bssshop_domain_model_client.phone',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'user' => [
            'exclude' => false,
            'label' => 'LLL:EXT:bss_shop/Resources/Private/Language/locallang_db.xlf:tx_bssshop_domain_model_client.user',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'fe_users',
                'minitems' => 0,
                'maxitems' => 1,
                'appearance' => [
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],
        ],
    
    ],
];
