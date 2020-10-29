<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

/*
 * Add EID functionality for ajax calls
 */
$TYPO3_CONF_VARS['FE']['eID_include']['bss_events'] = 'EXT:bss_events/Classes/Controller/AjaxController.php';


/*
 * Hook new RTE Image files
 */
//$GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['default'] = 'EXT:bss_events/Configuration/RTE/Default.yaml';


/*
 * Add Page ts config
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:bss_events/Configuration/TypoScript/pageTsConfig.ts">');


/*
 * Backend Icons
 */
if (TYPO3_MODE === 'BE') {
    $icons = [
        'ext-bss-events-calendar' => 'icon_calendar.png',
        'ext-bss-events-event' => 'icon_event.png',
        'ext-bss-events-appointment' => 'icon_termin.png',
        'ext-bss-events-category' => 'icon_kategorien.png',
        'ext-bss-events-event-setting' => 'icon_event_option.png',
        'ext-bss-events-appointment-setting' => 'icon_termin_option.png',
        'ext-bss-events-subscriber' => 'icon_teilnehmer.png',
    ];
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    foreach ($icons as $identifier => $path) {
        $iconRegistry->registerIcon(
            $identifier,
            \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
            ['source' => 'EXT:bss_events/Resources/Public/Icons/' . $path]
        );
    }
}


/*
 * Configure Plugin 1 for Event Plugin
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Bermuda.bss_events',
    'P1',
    array('Event' => 'show,detail,subscribe,create,export,edit,delete,appointmentFileUpload,removeAppointmentFile'),
    array('Event' => 'show,detail,subscribe,create,export,edit,delete,appointmentFileUpload,removeAppointmentFile')
);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerTypeConverter('Bermuda\\BssEvents\\Property\\TypeConverter\\UploadedFileReferenceConverter');
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerTypeConverter('Bermuda\\BssEvents\\Property\\TypeConverter\\ObjectStorageConverter');
