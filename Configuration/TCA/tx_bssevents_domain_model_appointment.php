<?php
if (!defined('TYPO3_MODE')) die ('Access denied.');

return [
    'ctrl' => [
        'title' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_appointment.appointment',
        'label' => 'Event  |  Start  -  End',
        'label_userFunc' => 'Bermuda\\BssEvents\\Userfunctions\\Tca->getAppointmentTitle',
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
            'default' => 'ext-bss-events-appointment'
        ],
        'hideTable' => true,
        'searchFields' => 'date_from, date_to, registration, subscribers, state, repeat_weekly, childs',
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden, date_from, date_to, registration, subscribers, state, repeat_weekly, childs',
    ],
    'types' => [
        '1' => ['showitem' => 'date_from, date_to, registration, subscribers, state, repeat_weekly, childs'],
    ],
    'columns' => [
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
        'date_from' => [
            'exclude' => false,
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_appointment.date_from',
            'config' => [
                'type' => 'input',
                'size' => 16,
                'eval' => 'datetime',
                'default' => '0',
            ],
        ],
        'date_to' => [
            'exclude' => false,
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_appointment.date_to',
            'config' => [
                'type' => 'input',
                'size' => 16,
                'eval' => 'datetime',
                'default' => '0',
            ],
        ],
        'registration' => [
            'exclude' => false,
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_registration.registration',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_bssevents_domain_model_registration',
                'maxitems' => 1,
                'minitems' => 0,
            ],
        ],
        'subscribers' => [
            'exclude' => false,
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_subscriber.subscriber',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_bssevents_domain_model_subscriber',
                'foreign_field' => 'appointment',
                'maxitems' => 9999,
                'appearance' => [
                    'collapseAll' => 1,
                    'expandSingle' => 0,
                ],
            ],
        ],
        'state' => [
            'exclude' => false,
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_appointment.state',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_appointment.state.active', 'active'],
                    ['LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_appointment.state.archived', 'archived'],
                    ['LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_appointment.state.disabled', 'disabled'],
                ],
            ],
        ],
        'event' => [
            'exclude' => false,
            'label' => 'Event',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_bssevents_domain_model_event',
                'maxitems' => 1,
                'minitems' => 1,
            ],
        ],
        'repeat_weekly' => array(
            'exclude' => false,
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_appointment_exception.repeat_weekly',
            'config' => array(
                'type' => 'check',
                'default' => 0,
            ),
        ),
        'active' => array(
            'exclude' => false,
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_event.active',
            'config' => array(
                'type' => 'check',
                'default' => 1,
            ),
        ),
        'parent' => [
            'exclude' => false,
            'label' => 'Parent',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_bssevents_domain_model_appointment',
                'maxitems' => 1,
                'minitems' => 1,
            ],
        ],
        'childs' => [
            'exclude' => false,
            'label' => 'Childs',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_bssevents_domain_model_appointment',
                'foreign_field' => 'parent',
                'appearance' => [
                    'collapseAll' => 1,
                    'expandSingle' => 0,
                ],
            ],
        ],
        'files' => [
            'exclude' => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'Files',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'files',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'Add File',
                        'showPossibleLocalizationRecords' => true,
                        'showRemovedLocalizationRecords' => true,
                        'showAllLocalizationLink' => true,
                        'showSynchronizationLink' => true
                    ],
                    'inline' => [
                        'inlineOnlineMediaAddButtonStyle' => 'display:none'
                    ],
                    'foreign_match_fields' => [
                        'fieldname' => 'files',
                        'tablenames' => 'tx_bssevents_domain_model_appointment',
                        'table_local' => 'sys_file',
                    ],
                ]
            )
        ],
    ],
];