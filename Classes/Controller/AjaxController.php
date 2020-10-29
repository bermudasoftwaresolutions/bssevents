<?php
namespace Bermuda\BssEvents\Controller;

use Bermuda\BssEvents\Domain\Model\Event;
use Bermuda\BssEvents\Domain\Repository\EventRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;

class AjaxController
{

    /** @var null|ObjectManager $objectManager */
    protected $objectManager = null;

    /** @var null|EventRepository $eventRepository */
    protected $eventRepository = null;

    /** @var null|PersistenceManager $persistenceManager */
    protected $persistenceManager = null;



    function __construct()
    {
        @set_time_limit(300);
        $this->initTSFE();

        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->eventRepository = $this->objectManager->get(EventRepository::class);
        $this->persistenceManager = $this->objectManager->get(PersistenceManager::class);
    }



    public function main(){

        /** @var EventController $eventController */
        $eventController = $this->objectManager->get(EventController::class);
        $eventController->showAction();

        $test = $this->eventRepository->findAll();
        $test = $test->toArray();

        $newEvent = new Event($this->randomString(), $this->randomString(), $this->randomString(), $this->randomString());
        $this->eventRepository->add($newEvent);

        # Mit dem Vorschlaghammer in die Datenbank speichern / Nägel mit Köpfen machen
        $this->persistenceManager->persistAll();

    }

    /**
     * Initializes TSFE and sets $GLOBALS['TSFE']
     *
     * @return	void
     */
    protected function initTSFE() {
        $GLOBALS['TSFE'] = $tsfe = GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\Controller\\TypoScriptFrontendController', $GLOBALS['TYPO3_CONF_VARS'], GeneralUtility::_GP('id'), '');
        /** @var \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $tsfe */
        $tsfe->connectToDB();
        $tsfe->initFEuser();
        \TYPO3\CMS\Frontend\Utility\EidUtility::initTCA();
        $tsfe->determineId();
        $tsfe->initTemplate();
        $tsfe->getConfigArray();
        $tsfe->settingLanguage();

        // Get linkVars, absRefPrefix, etc
        \TYPO3\CMS\Frontend\Page\PageGenerator::pagegenInit();
    }


    /**
     * @return string
     */
    private function randomString()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 10; $i++) {
            $randstring = $characters[rand(0, strlen($characters))];
        }
        return $randstring;
    }

}

$ajaxController = GeneralUtility::makeInstance('Bermuda\\BssEvents\\Controller\\AjaxController');
/* @var AjaxController $ajaxController */
$ajaxController->main();