<?php
if (!defined('TYPO3_MODE')) die ('Access denied.');

return [
    'ctrl' => array(
        'title' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_eventoption.eventoption',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'typeicon_classes' => [
            'default' => 'ext-bss-events-event-setting'
        ],
        'hideTable' => true,
        'searchFields' => 'title, type, values, selection',
    ),
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, type, values, selection',
    ],
    'types' => array(
        '0' => array('showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, type, values, selection')
    ),
    'columns' => array(
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
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
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_bssevents_domain_model_eventoption',
                'foreign_table_where' => 'AND tx_bssevents_domain_model_eventoption.pid=###CURRENT_PID### AND tx_bssevents_domain_model_eventoption.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
            ]
        ],
        'endtime' => [
            'exclude' => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ]
            ],
        ],

        'title' => array(
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_eventoption.title',
            'config' => array(
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim,required'
            )
        ),
        'type' => array(
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_eventoption.type',
            'config' => array(
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim,required'
            )
        ),
        'values' => array(
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_eventoption.values',
            'config' => array(
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim,required'
            )
        ),
        'selection' => array(
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_eventoption.selection',
            'config' => array(
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim'
            )
        ),
    ),

];