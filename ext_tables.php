<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('bss_events');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToInsertRecords('bss_events');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bssevents_domain_model_category');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToInsertRecords('tx_bssevents_domain_model_category');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bssevents_domain_model_event');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToInsertRecords('tx_bssevents_domain_model_event');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bssevents_domain_model_eventoption');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToInsertRecords('tx_bssevents_domain_model_eventoption');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bssevents_domain_model_appointment');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToInsertRecords('tx_bssevents_domain_model_appointment');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bssevents_domain_model_datesetting');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToInsertRecords('tx_bssevents_domain_model_datesetting');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bssevents_domain_model_subscriber');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToInsertRecords('tx_bssevents_domain_model_subscriber');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bssevents_domain_model_registration');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToInsertRecords('tx_bssevents_domain_model_registration');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bssevents_domain_model_appointmentexception');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToInsertRecords('tx_bssevents_domain_model_appointmentexception');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Bermuda.bss_events',
    'P1',
    'Event Plugin'
);


/**
 * Include Flexform
 */
// Pi1
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['bssevents_p1'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'bssevents_p1',
    'FILE:EXT:bss_events/Configuration/FlexForms/FlexformPi1.xml'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('bss_events', 'Configuration/TypoScript', 'Bermuda Events');