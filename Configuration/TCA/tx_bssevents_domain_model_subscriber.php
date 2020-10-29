<?php
if (!defined('TYPO3_MODE')) die ('Access denied.');

return [
    'ctrl' => array(
        'title' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_subscriber.subscriber',
        'label' => 'lastname', // todo: generate label by controller
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'typeicon_classes' => [
            'default' => 'ext-bss-events-subscriber'
        ],
        'hideTable' => true,
        'searchFields' => 'hidden, firstname, lastname, email, phone, street, number, zip, city, message, appointment, creator',
    ),
    'interface' => [
        'showRecordFieldList' => 'hidden, firstname, lastname, email, phone, street, number, zip, city, message, appointment, creator',
    ],
    'types' => array(
        '0' => array('showitem' => 'firstname, lastname, email, phone, street, number, zip, city, message, appointment, creator')
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

        'firstname' => array(
            'exclude' => false,
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_subscriber.firstname',
            'config' => array(
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim,required'
            )
        ),
        'lastname' => array(
            'exclude' => false,
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_subscriber.lastname',
            'config' => array(
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim,required'
            )
        ),
        'email' => array(
            'exclude' => false,
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_subscriber.email',
            'config' => array(
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim'
            )
        ),
        'phone' => array(
            'exclude' => false,
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_subscriber.phone',
            'config' => array(
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim'
            )
        ),
        'street' => array(
            'exclude' => false,
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_subscriber.street',
            'config' => array(
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim'
            )
        ),
        'zip' => array(
            'exclude' => false,
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_subscriber.zip',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'eval' => 'trim'
            )
        ),
        'city' => array(
            'exclude' => false,
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_subscriber.city',
            'config' => array(
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim'
            )
        ),
        'message' => array(
            'exclude' => false,
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_subscriber.message',
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
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_subscriber.appointment',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_bssevents_domain_model_appointment',
                'maxitems' => 1,
                'minitems' => 1,
            ],
        ],
        'creator' => [
            'exclude' => false,
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_subscriber.creator',
            'config' => [
                'type' => 'user',
                'size' => '30',
                'userFunc' => 'Bermuda\\BssEvents\\Userfunctions\\Tca->getFeUser',
            ],
        ],
    ),
];