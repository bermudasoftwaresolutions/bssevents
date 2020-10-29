<?php
namespace Bermuda\BssEvents\Controller;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;


abstract class AbstractController extends ActionController
{

    /**
     * @var \Bermuda\BssEvents\Domain\Repository\EventRepository
     * @inject */
    protected $eventRepository;

    /**
     * @var \Bermuda\BssEvents\Domain\Repository\AppointmentRepository
     * @inject */
    protected $appointmentRepository;

    /**
     * @var \Bermuda\BssEvents\Domain\Repository\CategoryRepository
     * @inject */
    protected $categoryRepository;

    /**
     * @var \Bermuda\BssEvents\Domain\Repository\DatesettingRepository
     * @inject */
    protected $datesettingRepository;

    /**
     * @var \Bermuda\BssEvents\Domain\Repository\EventoptionRepository
     * @inject */
    protected $eventoptionRepository;

    /**
     * @var \Bermuda\BssEvents\Domain\Repository\SubscriberRepository
     * @inject */
    protected $subscriberRepository;

    protected function initializeAction(){

        //Override and set language to de
        //$GLOBALS['TSFE']->sys_language_isocode = 'de';

        $this->response->addAdditionalHeaderData('<link rel="stylesheet" type="text/css" href="' . ExtensionManagementUtility::siteRelPath($this->request->getControllerExtensionKey()) . 'Resources/Public/css/main.css" >');
        $this->response->addAdditionalHeaderData('<script type="text/javascript" src="' . ExtensionManagementUtility::siteRelPath($this->request->getControllerExtensionKey()) . 'Resources/Public/vendor/tinymce/tinymce.jquery.min.js" /></script>');
        //$this->response->addAdditionalHeaderData('<script type="text/javascript" > moment.locale("' . $GLOBALS['TSFE']->sys_language_isocode . '"); </script>');
        $this->response->addAdditionalHeaderData('<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">');

        $this->response->addAdditionalHeaderData('<link rel="stylesheet" type="text/css" href="' . ExtensionManagementUtility::siteRelPath($this->request->getControllerExtensionKey()) . 'Resources/Public/vendor/datetimepicker/build/jquery.datetimepicker.min.css" >');
        $this->response->addAdditionalHeaderData('<script type="text/javascript" src="' . ExtensionManagementUtility::siteRelPath($this->request->getControllerExtensionKey()) . 'Resources/Public/vendor/datetimepicker/build/jquery.datetimepicker.full.min.js" /></script>');

        $this->response->addAdditionalHeaderData('<link rel="stylesheet" type="text/css" href="' . ExtensionManagementUtility::siteRelPath($this->request->getControllerExtensionKey()) . 'Resources/Public/vendor/bootstrap-toggle/css/bootstrap4-toggle.min.css" >');
        $this->response->addAdditionalHeaderData('<script type="text/javascript" src="' . ExtensionManagementUtility::siteRelPath($this->request->getControllerExtensionKey()) . 'Resources/Public/vendor/bootstrap-toggle/js/bootstrap4-toggle.min.js" /></script>');
    }
}