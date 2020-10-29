<?php
if (!defined('TYPO3_MODE')) die ('Access denied.');

return [
    'ctrl' => array(
        'title' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_registration.registration',
        'label' => 'repeat_type',
        'label_userFunc' => 'Bermuda\\BssEvents\\Userfunctions\\Tca->getRegistrationTitle',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'hideTable' => true,
        'typeicon_classes' => [
            'default' => 'ext-bss-events-appointment-setting'
        ],
        'searchFields' => 'public, message, slots',
    ),
    'interface' => [
        'showRecordFieldList' => 'hidden, public, message, slots',
    ],
    'types' => array(
        '0' => array('showitem' => 'public, message, slots'),
    ),
    'columns' => array(
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

        'public' => array(
            'exclude' => false,
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_registration.public',
            'config' => array(
                'type' => 'check',
                'default' => 0,
            ),
        ),
        'close' => array(
            'exclude' => false,
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_registration.close',
            'config' => array(
                'type' => 'check',
                'default' => 0,
            ),
        ),
        'message' => array(
            'exclude' => false,
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_registration.message',
            'config' => array(
                'type' => 'text',
                'cols' => 40,
                'rows' => 6,
                'enableRichtext' => true,
                'eval' => 'trim'
            )
        ),
        'appointment' => [
            'exclude' => false,
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_registration.appointment',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_bssevents_domain_model_appointment',
                'maxitems' => 1,
                'minitems' => 1,
            ],
        ],
        'slots' => [
            'exclude' => false,
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_event.slots',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'double2'
            ]
        ],
    ),
];