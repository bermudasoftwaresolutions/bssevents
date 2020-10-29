<?php
namespace Bermuda\BssEvents\Userfunctions;

use Bermuda\BssEvents\Domain\Model\Appointment;
use Bermuda\BssEvents\Domain\Repository\AppointmentRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class Tca
{

    public function getDatesettingTitle(&$args, &$pObj){

        $args['title'] = LocalizationUtility::translate('LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_datesetting.datesetting');

    }

    public function getRegistrationTitle(&$args, &$pObj){

        if($args['row']['public']){
            $state = LocalizationUtility::translate('LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_registration.ispublic');
        } else {
            $state = LocalizationUtility::translate('LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_registration.isnotpublic');
        }
        $args['title'] = $state . " " . LocalizationUtility::translate('LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_registration.registration');

    }

    public function getAppointmentTitle(&$args, &$pObj){

        $objectManager = GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
        $repository = $objectManager->get(AppointmentRepository::class);

        /** @var Appointment $appointment */
        $res = $repository->findByUid($args['row']['uid'])->getEvent()->getTitle() . "  |  ";

        $res .= date('d.m.Y H:i', $args['row']['date_from']);
        $res .= '  -  ';
        $res .= date('d.m.Y H:i', $args['row']['date_to']);

        $args['title'] = $res;
    }

    public function getFeUser(&$args, &$pObj){

        $objectManager = GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
        $repository = $objectManager->get(FrontendUserRepository::class);
        if($args['row']['creator'] == 0){
            return "<div>" . LocalizationUtility::translate("LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_user.unknown", null, [0 => "lms"]) . "</div>";
        }else{
            /** @var FrontendUser $user */
            $user = $repository->findByUid($args['row']['creator']);
            if($user != null){
                return "<div>" . LocalizationUtility::translate("LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_user.known", null, [0 => $user->getFirstname() . " " . $user->getLastName()]) . "</div>";
            } else {
                return "<div>" . LocalizationUtility::translate("LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_user.invalid", null, [0 => $args['row']['creator']]) . "</div>";
            }
        }
    }
}