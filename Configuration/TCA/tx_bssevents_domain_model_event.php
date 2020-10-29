<?php
if (!defined('TYPO3_MODE')) die ('Access denied.');

return [
    'ctrl' => array(
        'title' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_event.event',
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
            'default' => 'ext-bss-events-event'
        ],
        'hideTable' => true,
        'searchFields' => 'title, place, organizer, body, categories, appointments, image',
    ),
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, place, organizer, body, categories, appointments, image',
    ],
    'types' => array(
        '0' => array('showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, place, organizer, body, categories, appointments, image')
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
                'foreign_table' => 'tx_bssevents_domain_model_event',
                'foreign_table_where' => 'AND tx_bssevents_domain_model_event.pid=###CURRENT_PID### AND tx_bssevents_domain_model_event.sys_language_uid IN (-1,0)',
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
            'exclude' => false,
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_event.title',
            'config' => array(
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim,required'
            )
        ),
        'place' => array(
            'exclude' => false,
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_event.venue',
            'config' => array(
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim,required'
            )
        ),
        'organizer' => array(
            'exclude' => false,
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_event.organizer',
            'config' => array(
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim,required'
            )
        ),
        'body' => array(
            'exclude' => false,
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_event.content',
            'config' => array(
                'type' => 'text',
                'cols' => 40,
                'rows' => 6,
                'enableRichtext' => true,
                'eval' => 'trim, required'
            )
        ),
        'state' => array(
            'exclude' => false,
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_event.state',
            'config' => array(
                'type' => 'select',
                'items' => array(
                    array('LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_event.state.new', 'new'),
                    array('LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_event.state.active', 'active'),
                    array('LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_event.state.archived', 'archived'),
                )
            )
        ),
        'creator_uid' => array(
            'exclude' => false,
            'label' => 'Creator Uid',
            'config' => array(
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            )
        ),
        'categories' => [
            'exclude' => false,
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_event.categories',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_bssevents_domain_model_category',
                'MM' => 'tx_bssevents_event_category_mm',
                'size' => 10,
                'autoSizeMax' => 30,
                'maxitems' => 9999,
                'multiple' => 0,
                'wizards' => [
                    '_PADDING' => 1,
                    '_VERTICAL' => 1,
                    'edit' => [
                        'module' => [
                            'name' => 'wizard_edit',
                        ],
                        'type' => 'popup',
                        'title' => 'Edit', // todo define label: LLL:EXT:.../Resources/Private/Language/locallang_tca.xlf:wizard.edit
                        'icon' => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_edit.gif',
                        'popup_onlyOpenIfSelected' => 1,
                        'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
                    ],
                    'add' => [
                        'module' => [
                            'name' => 'wizard_add',
                        ],
                        'type' => 'script',
                        'title' => 'Create new', // todo define label: LLL:EXT:.../Resources/Private/Language/locallang_tca.xlf:wizard.add
                        'icon' => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_add.gif',
                        'params' => [
                            'table' => 'tx_bssevents_domain_model_category',
                            'pid' => '###CURRENT_PID###',
                            'setValue' => 'prepend'
                        ],
                    ],
                ],
            ],
        ],
        'appointments' => [
            'exclude' => false,
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_event.appointments',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_bssevents_domain_model_appointment',
                'foreign_field' => 'event',
                'maxitems' => 9999,
                'appearance' => [
                    'collapseAll' => 1,
                    'expandSingle' => 0,
                ],
            ],
        ],
        'image' => [
            'exclude' => false,
            'label' => 'LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_event.image',
            'config' =>
                \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                    'image',
                    [
                        'appearance' => [
                            'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
                        ],
                        'foreign_types' => [
                            '0' => [
                                'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                                'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                                'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                                'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                                'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                            ]
                        ],
                        'maxitems' => 99
                    ],
                    $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
                ),

        ],
    ),
];