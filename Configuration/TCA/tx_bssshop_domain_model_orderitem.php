<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:bss_shop/Resources/Private/Language/locallang_db.xlf:tx_bssshop_domain_model_orderitem',
        'label' => 'product_name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'sortby' => 'sorting',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'enablecolumns' => [
        ],
        'searchFields' => 'product_name,build_name,code',
        'iconfile' => 'EXT:bss_shop/Resources/Public/Icons/tx_bssshop_domain_model_orderitem.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, product_name, build_name, code, amount, price, total, product, build',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, product_name, build_name, code, amount, price, total, product, build'],
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
                'foreign_table' => 'tx_bssshop_domain_model_orderitem',
                'foreign_table_where' => 'AND {#tx_bssshop_domain_model_orderitem}.{#pid}=###CURRENT_PID### AND {#tx_bssshop_domain_model_orderitem}.{#sys_language_uid} IN (-1,0)',
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

        'product_name' => [
            'exclude' => false,
            'label' => 'LLL:EXT:bss_shop/Resources/Private/Language/locallang_db.xlf:tx_bssshop_domain_model_orderitem.product_name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'build_name' => [
            'exclude' => false,
            'label' => 'LLL:EXT:bss_shop/Resources/Private/Language/locallang_db.xlf:tx_bssshop_domain_model_orderitem.build_name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'code' => [
            'exclude' => false,
            'label' => 'LLL:EXT:bss_shop/Resources/Private/Language/locallang_db.xlf:tx_bssshop_domain_model_orderitem.code',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'amount' => [
            'exclude' => false,
            'label' => 'LLL:EXT:bss_shop/Resources/Private/Language/locallang_db.xlf:tx_bssshop_domain_model_orderitem.amount',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ]
        ],
        'price' => [
            'exclude' => false,
            'label' => 'LLL:EXT:bss_shop/Resources/Private/Language/locallang_db.xlf:tx_bssshop_domain_model_orderitem.price',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'double2'
            ]
        ],
        'total' => [
            'exclude' => false,
            'label' => 'LLL:EXT:bss_shop/Resources/Private/Language/locallang_db.xlf:tx_bssshop_domain_model_orderitem.total',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'double2'
            ]
        ],
        'product' => [
            'exclude' => false,
            'label' => 'LLL:EXT:bss_shop/Resources/Private/Language/locallang_db.xlf:tx_bssshop_domain_model_orderitem.product',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_bssshop_domain_model_product',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'build' => [
            'exclude' => false,
            'label' => 'LLL:EXT:bss_shop/Resources/Private/Language/locallang_db.xlf:tx_bssshop_domain_model_orderitem.build',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_bssshop_domain_model_build',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
    
        'tx_order' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
];
