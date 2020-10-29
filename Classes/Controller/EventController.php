<?php

namespace Bermuda\BssEvents\Controller;

use Bermuda\BssEvents\Domain\Model\Appointment;
use Bermuda\BssEvents\Domain\Model\DetailDaySet;
use Bermuda\BssEvents\Domain\Model\Event;
use Bermuda\BssEvents\Domain\Model\Month;
use Bermuda\BssEvents\Domain\Model\Registration;
use Bermuda\BssEvents\Domain\Model\Subscriber;
use Bermuda\BssEvents\Domain\Model\Year;
use Bermuda\BssEvents\Property\TypeConverter\UploadedFileReferenceConverter;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Error\Error;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Extbase\Property\PropertyMappingConfiguration;


class EventController extends AbstractController
{

    /** @var \Bermuda\BssEvents\Domain\Repository\SubscriberRepository
     * @inject
     */
    protected $subscriberRepository;


    /** @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
     * @inject
     */
    protected $feUserRepo;

    /** @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserGroupRepository
     * @inject
     */
    protected $feUserGroupRepo;

    /** @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager;

    /** @var \TYPO3\CMS\Core\Resource\StorageRepository
     * @inject
     */
    protected $storageRepository;


    public function showAction()
    {
        if ($this->request->hasArgument('dayString')) {
            $month = $this->objectManager->get(DetailDaySet::class);
            $month->initialize(
                $this->request->getArguments()
            );
        } else {
            if ($this->settings['bssEvents']['main']['output'] == 'yearlist') {
                $year = $this->objectManager->get(Year::class);
                $year->initialize(
                    $this->request->getArguments(),
                    $this->settings['bssEvents']
                );
            }

            $month = $this->objectManager->get(Month::class);
            $month->initialize(
                $this->request->getArguments(),
                $this->settings['bssEvents']
            );
        }

        /* Handle FrontendUser rights */
        /** @var FrontendUser|null $user */
        $user = $this->feUserRepo->findByUid(
            $GLOBALS['TSFE']->fe_user->user['uid']
        );
        if ($user instanceof FrontendUser) {
            $isCreator = $user->getUsergroup()->contains(
                $this->feUserGroupRepo->findByUid(
                    $this->settings['creatorGid']
                )
            );
            $this->view->assign('isCreator', $isCreator);
            $isModerator = $user->getUsergroup()->contains(
                $this->feUserGroupRepo->findByUid(
                    $this->settings['moderatorGid']
                )
            );
            $this->view->assign('isModerator', $isModerator);
        } else {
            $this->view->assign('isCreator', false);
            $this->view->assign('isModerator', false);
        }

        if ($isCreator || $isModerator) {
            $this->view->assign('showCreateBtn', true);
        }

        $this->view->assign('month', $month);

        if ($year) {
            $this->view->assign('year', $year);
        }
        $this->view->assign('user', $user);
        $this->view->assign('categories', $this->categoryRepository->findAll());
    }

    /**
     * @param Appointment $appointment
     */
    public function detailAction(Appointment $appointment)
    {

        /* Handle FrontendUser rights */
        /** @var FrontendUser|null $user */
        $user = $this->feUserRepo->findByUid(
            $GLOBALS['TSFE']->fe_user->user['uid']
        );

        // check role permissions for internal informations and functions
        try {
            $isCreator = $user->getUsergroup()->contains(
                $this->feUserGroupRepo->findByUid(
                    $this->settings['creatorGid']
                )
            );
        } catch (\Error $e) {
            $isCreator = false;
        }

        // check role permissions for moderation
        try {
            $isModerator = $user->getUsergroup()->contains(
                $this->feUserGroupRepo->findByUid(
                    $this->settings['moderatorGid']
                )
            );
        } catch (\Error $e) {
            $isModerator = false;
        }

        // check if user is permitted
        if ($isCreator || $isModerator) {
            $isPermitted = true;
        } else {
            $isPermitted = false;
        }

        // check if user is the event creator
        if ($appointment->getEvent()->getCreatorUid() == $GLOBALS['TSFE']->fe_user->user['uid']) {
            $isCreator = true;
        } else {
            $isCreator = false;
        }

        // handle if user can delete event
        if (!$isModerator) {
            if ($appointment->getSubscribers()->count() > 0) {
                $canDelete = false;
            } elseif (!$isCreator) {
                $canDelete = false;
            } else {
                $canDelete = true;
            }
        } else {
            $canDelete = true;
        }


        if (!$_POST['ajax']) {
            $this->view->assign('appointment', $appointment);
            $this->view->assign('isModerator', $isModerator);
            $this->view->assign('isCreator', $isCreator);
            $this->view->assign('isPermitted', $isPermitted);
            $this->view->assign('canDelete', $canDelete);
            $this->view->assign('user', $user);
        } else {

            $eventUid = $appointment->getEvent();
            $registration = $appointment->getRegistration();

            if (isset($eventUid) && isset($registration)) {

                $registerUsers = count($this->subscriberRepository->getAllRegisterUsersByEvent($appointment->getEvent()->getUid(), $appointment->getRegistration()->getUid()));
            } else {
                $registerUsers = 0;
            }

            $getSlots = $appointment->getRegistration();
            if (isset($getSlots)) {
                $slots = $appointment->getRegistration()->getSlots();
                $different = $slots - $registerUsers;

            } else {
                $different = 0;
            }

            /** @var \TYPO3\CMS\Fluid\View\StandaloneView $standaloneView */
            $standaloneView = $this->objectManager->get(StandaloneView::class);
            $standaloneView->setLayoutRootPaths(
                array(GeneralUtility::getFileAbsFileName('EXT:bss_events/Resources/Private/Layouts'))
            );
            $standaloneView->setPartialRootPaths(
                array(GeneralUtility::getFileAbsFileName('EXT:bss_events/Resources/Private/Partials'))
            );
            $standaloneView->setTemplateRootPaths(
                array(GeneralUtility::getFileAbsFileName('EXT:bss_events/Resources/Private/Templates'))
            );
            $standaloneView->setTemplate('Event/Detail.html');


            $standaloneView->assign('user', $user);
            $standaloneView->assign('slots', $slots);
            $standaloneView->assign('availableSlots', $different);
            $standaloneView->assign('appointment', $appointment);
            $standaloneView->assign('isModerator', $isModerator);
            $standaloneView->assign('isCreator', $isCreator);
            $standaloneView->assign('isPermitted', $isPermitted);
            $standaloneView->assign('canDelete', $canDelete);
            $standaloneView->assign('settings', $this->settings);


            echo $standaloneView->render();
            die;
        }
    }


    /**
     * @param Appointment $appointment
     */
    public function deleteAction(Appointment $appointment)
    {
        /* Handle FrontendUser rights */
        /** @var FrontendUser|null $user */
        $user = $this->feUserRepo->findByUid(
            $GLOBALS['TSFE']->fe_user->user['uid']
        );

        // check role permissions for moderation
        try {
            $isModerator = $user->getUsergroup()->contains(
                $this->feUserGroupRepo->findByUid(
                    $this->settings['moderatorGid']
                )
            );
        } catch (\Error $e) {
            $isModerator = false;
        }

        // check if user is the event creator
        if ($appointment->getEvent()->getCreatorUid() == $GLOBALS['TSFE']->fe_user->user['uid']) {
            $isCreator = true;
        } else {
            $isCreator = false;
        }

        // handle if user can delete event
        if (!$isModerator) {
            if ($appointment->getSubscribers()->count() > 0) {
                $canDelete = false;
            } elseif (!$isCreator) {
                $canDelete = false;
            } else {
                $canDelete = true;
            }
        } else {
            $canDelete = true;
        }

        header('Content-Type: application/json');
        if ($canDelete) {

            $this->eventRepository->remove($appointment->getEvent());
            $this->persistenceManager->persistAll();
            $this->addFlashMessage('', LocalizationUtility::translate("LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_event.delete_success"), AbstractMessage::OK);

            echo json_encode(
                array(
                    'error' => false,
                    'message' => 'Successful deleted'
                )
            );
            die;

        } else {

            echo json_encode(
                array(
                    'error' => true,
                    'message' => LocalizationUtility::translate("LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_event.delete_permission")
                )
            );
            die;

        }
    }


    public function initializeCreateAction()
    {

        $this->setTypeConverterConfigurationForImageUpload('event');

        if ($this->request->hasArgument('event')) {
            $event = $this->request->getArgument('event');
            $propertyMappingConfiguration = $this->arguments->getArgument('event')->getPropertyMappingConfiguration();

            if (!empty($event['appointments'])) {
                $propertyMappingConfiguration->allowProperties('appointments');
                $propertyMappingConfiguration->forProperty('appointments')->allowAllProperties();
                $propertyMappingConfiguration->allowModificationForSubProperty('appointments');

                foreach ($event['appointments'] as $positionIndex => $positionPropertyArray) {
                    $propertyPath = 'appointments.' . $positionIndex;
                    $propertyMappingConfiguration->forProperty($propertyPath)->allowAllProperties();
                    $propertyMappingConfiguration->allowCreationForSubProperty($propertyPath);
                    $propertyMappingConfiguration->allowModificationForSubProperty($propertyPath);


                    foreach ($positionPropertyArray as $key => $item) {
                        if ($key == 'dateFrom' || $key == 'dateTo') {
                            $datePath = $propertyPath . '.' . $key;
                            $propertyMappingConfiguration
                                ->forProperty($datePath)
                                ->setTypeConverter(new \Bermuda\BssEvents\Converter\DateConverter());
                        }
                    }

                    // appointment childs
                    /*
                    $expropertyPath = 'appointments.' .$positionIndex . '.childs';
                    $propertyMappingConfiguration->allowProperties($expropertyPath);
                    $propertyMappingConfiguration->forProperty($expropertyPath)->allowAllProperties();
                    $propertyMappingConfiguration->allowModificationForSubProperty($expropertyPath);

                    if(!empty($positionPropertyArray['childs'])) {
                        foreach ($positionPropertyArray['childs'] as $expositionIndex => $expositionPropertyArray) {
                            $expropertyPath = 'appointments.' . $positionIndex . '.childs.' . $expositionIndex;
                            $propertyMappingConfiguration->forProperty($expropertyPath)->allowAllProperties();
                            $propertyMappingConfiguration->allowCreationForSubProperty($expropertyPath);
                            $propertyMappingConfiguration->allowModificationForSubProperty($expropertyPath);

                            foreach ($expositionPropertyArray as $key => $item) {
                                if ($key == 'dateFrom' || $key == 'dateTo') {
                                    $datePath = $expropertyPath . '.' . $key;
                                    $propertyMappingConfiguration
                                        ->forProperty($datePath)
                                        ->setTypeConverter(new \Bermuda\BssEvents\Converter\DateConverter());
                                }
                            }
                        }
                    }*/
                    // end exceptions

                    if (!empty($positionPropertyArray['datesetting'])) {
                        $propertyPath = $propertyPath . '.datesetting';
                        $propertyMappingConfiguration->forProperty($propertyPath)->allowAllProperties();
                        $propertyMappingConfiguration->allowCreationForSubProperty($propertyPath);
                        $propertyMappingConfiguration->allowModificationForSubProperty($propertyPath);
                    }

                    if (!empty($positionPropertyArray['registration'])) {
                        $propertyPath = $propertyPath . '.registration';
                        $propertyMappingConfiguration->forProperty($propertyPath)->allowProperties('public');
                        $propertyMappingConfiguration->forProperty($propertyPath)->allowProperties('close');
                        $propertyMappingConfiguration->forProperty($propertyPath)->allowProperties('message');
                        $propertyMappingConfiguration->forProperty($propertyPath)->allowProperties('slots');
                        $propertyMappingConfiguration->allowCreationForSubProperty($propertyPath);
                        $propertyMappingConfiguration->allowModificationForSubProperty($propertyPath);
                    }
                }
            }
        }
    }

    /**
     * @param \Bermuda\BssEvents\Domain\Model\Event $event
     * @return \TYPO3\CMS\Extbase\Mvc\View\ViewInterface
     */
    public function createAction($event = null)
    {

        if ($this->request->hasArgument('file')) {

            // Get all submitted post data
            $userData = $this->request->getArgument('file');


            // media is stand for your file name [ you will get data of image]

            $file['name'] = $userData['name'];
            $file['type'] = $userData['type'];
            $file['tmp_name'] = $userData['tmp_name'];
            $file['size'] = $userData['size'];

            // Store the image file
            $files = $this->uploadFile($file['name'], $file['type'], $file['tmp_name'], $file['size']);

            $event->setImageUpload($files);


        }


        /* Handle FrontendUser rights */
        /** @var FrontendUser|null $user */
        $user = $this->feUserRepo->findByUid(
            $GLOBALS['TSFE']->fe_user->user['uid']
        );
        try {
            $isCreator = $user->getUsergroup()->contains(
                $this->feUserGroupRepo->findByUid(
                    $this->settings['creatorGid']
                )
            );
        } catch (\Error $e) {
            $isCreator = false;
        }
        try {
            $isModerator = $user->getUsergroup()->contains(
                $this->feUserGroupRepo->findByUid(
                    $this->settings['moderatorGid']
                )
            );
        } catch (\Error $e) {
            $isModerator = false;
        }


        if (!($isCreator || $isModerator)) {
            $this->addFlashMessage('', LocalizationUtility::translate("LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_event.no_rights"), AbstractMessage::ERROR);
            return $this->redirect('show');
        }


        if ($event == null) {

            // new
            $this->view->assign('newEvent', new Event());
            $this->view->assign('language', $GLOBALS['TSFE']->sys_language_isocode);
            $this->view->assign('categories', $this->categoryRepository->findAll());
        } else {
            // save new to repository
            $event->setCreatorUid($GLOBALS['TSFE']->fe_user->user['uid']);

            $this->createRecurringAppointments($event);

            $this->eventRepository->add($event);
            $this->persistenceManager->persistAll();

            $this->addFlashMessage('', LocalizationUtility::translate("LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_event.create_success"), AbstractMessage::OK);
            //$this->redirect('show');
            $this->redirectToUri($_SERVER['HTTP_REFERER']);
        }


        if ($_POST['ajax']) {
            // ajax view call back
            header('Content-Type: application/json');
            echo json_encode(['error' => false, 'message' => $this->view->render()]);
            die;
        }


        // implicit view call back of ActionController
    }

    /**
     * uploadFile
     * @param $name
     * @param $type
     * @param $temp
     * @param $size
     * @return
     */

    protected function uploadFile($name, $type, $temp, $size)
    {

        if ($size > 0) {
            $basicFileFunctions = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Utility\\File\\BasicFileUtility');

            // upload folder path
            $uploadPath = 'fileadmin/user_upload/bss_events_uploaded_images';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath);
            }

            $name = $basicFileFunctions->cleanFileName($name);
            $uniqueFileName = $basicFileFunctions->getUniqueName($name, $uploadPath);
            move_uploaded_file($temp, $uniqueFileName);

            $returnValue = basename($uniqueFileName);
        }

        return $returnValue;
    }

    /**
     * @param \Bermuda\BssEvents\Domain\Model\Appointment $appointment
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */
    public function appointmentFileUploadAction($appointment)
    {

        $_POST['tx_bssevents_p1']['shownname'];

        $storage = $this->storageRepository->findByUid(1); #Fileadmin = 1
        if (!$storage->hasFolder('bss_events'))
            $storage->createFolder('bss_events');

        $saveFolder = $storage->getFolder('bss_events');

        $fileObject = $storage->addFile($_FILES['tx_bssevents_p1']['tmp_name']['file'], $saveFolder, $_FILES['tx_bssevents_p1']['name']['file']);

        $newFileReference = new \Bermuda\BssEvents\Domain\Model\AppointmentFileReference();
        $newFileReference->setOriginalResource($fileObject);

        $appointment->addFile($newFileReference);
        $this->appointmentRepository->update($appointment);
        $this->persistenceManager->persistAll();


        /**
         * does not work
         * jquery name input disabled
         */
        /*
        if(strlen($_POST['tx_bssevents_p1']['shownname']) > 0){
            $this->eventRepository->updateFileReferenceTitle($newFileReference->getUid(), $_POST['tx_bssevents_p1']['shownname']);
            $this->persistenceManager->persistAll();
        }
        */

        $standaloneView = $this->objectManager->get(StandaloneView::class);
        $standaloneView->setLayoutRootPaths(
            array(GeneralUtility::getFileAbsFileName('EXT:bss_events/Resources/Private/Layouts'))
        );
        $standaloneView->setPartialRootPaths(
            array(GeneralUtility::getFileAbsFileName('EXT:bss_events/Resources/Private/Partials'))
        );
        $standaloneView->setTemplateRootPaths(
            array(GeneralUtility::getFileAbsFileName('EXT:bss_events/Resources/Private/Templates'))
        );

        $html = $standaloneView->renderPartial('NewFileRow.html', 'main', ['appointment' => $appointment, 'file' => $newFileReference]);

        //$html = $this->editAction($appointment->getEvent(), false, true);

        echo "<script>window.top.window.updateEditView(" . json_encode($html) . ");</script>";
        die;
    }


    /**
     * @param \Bermuda\BssEvents\Domain\Model\Appointment $appointment
     * @param \Bermuda\BssEvents\Domain\Model\AppointmentFileReference $file
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */
    public function removeAppointmentFileAction($appointment, $file)
    {

        /** @var ResourceFactory $resourceFactory */
        $resourceFactory = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\ResourceFactory');
        $fileReferenceObject = $resourceFactory->getFileReferenceObject($file->getUid());
        $fileWasDeleted = $fileReferenceObject->getOriginalFile()->delete();

        $appointment->removeFile($file);
        $this->persistenceManager->persistAll();

        $html = $this->editAction($appointment->getEvent(), false, true);

        echo "<script>window.top.window.removeFile();</script>";
        die;
    }


    public function initializeEditAction()
    {

        $this->setTypeConverterConfigurationForImageUpload('event');

        if ($this->request->hasArgument('event')) {
            $event = $this->request->getArgument('event');
            $propertyMappingConfiguration = $this->arguments->getArgument('event')->getPropertyMappingConfiguration();

            if (!empty($event['appointments'])) {
                $propertyMappingConfiguration->allowProperties('appointments');
                $propertyMappingConfiguration->forProperty('appointments')->allowAllProperties();
                $propertyMappingConfiguration->allowModificationForSubProperty('appointments');

                foreach ($event['appointments'] as $positionIndex => $positionPropertyArray) {
                    $propertyPath = 'appointments.' . $positionIndex;
                    $propertyMappingConfiguration->forProperty($propertyPath)->allowAllProperties();
                    $propertyMappingConfiguration->allowCreationForSubProperty($propertyPath);
                    $propertyMappingConfiguration->allowModificationForSubProperty($propertyPath);

                    foreach ($positionPropertyArray as $key => $item) {
                        if ($key == 'dateFrom' || $key == 'dateTo') {
                            $datePath = $propertyPath . '.' . $key;
                            $propertyMappingConfiguration
                                ->forProperty($datePath)
                                ->setTypeConverter(new \Bermuda\BssEvents\Converter\DateConverter());
                        }
                    }

                    // exceptions
                    /*
                    if(!empty($positionPropertyArray['appointmentExceptions'])){

                        $expropertyPath = 'appointments.' .$positionIndex . '.appointmentExceptions';
                        $propertyMappingConfiguration->allowProperties($expropertyPath);
                        $propertyMappingConfiguration->forProperty($expropertyPath)->allowAllProperties();
                        $propertyMappingConfiguration->allowModificationForSubProperty($expropertyPath);

                        foreach($positionPropertyArray['appointmentExceptions'] as $expositionIndex => $expositionPropertyArray) {
                            $expropertyPath = 'appointments.' .$positionIndex . '.appointmentExceptions.' . $expositionIndex;
                            $propertyMappingConfiguration->forProperty($expropertyPath)->allowAllProperties();
                            $propertyMappingConfiguration->allowCreationForSubProperty($expropertyPath);
                            $propertyMappingConfiguration->allowModificationForSubProperty($expropertyPath);

                            foreach ($expositionPropertyArray as $key => $item) {
                                if($key == 'dateFrom' || $key == 'dateTo'){
                                    $datePath = $expropertyPath.'.'.$key;
                                    $propertyMappingConfiguration
                                        ->forProperty($datePath)
                                        ->setTypeConverter(new \Bermuda\BssEvents\Converter\DateConverter());
                                }
                            }
                        }
                    }*/
                    // end exceptions

                    if (!empty($positionPropertyArray['datesetting'])) {
                        $propertyPath = $propertyPath . '.datesetting';
                        $propertyMappingConfiguration->forProperty($propertyPath)->allowAllProperties();
                        $propertyMappingConfiguration->allowCreationForSubProperty($propertyPath);
                        $propertyMappingConfiguration->allowModificationForSubProperty($propertyPath);
                    }

                    if (!empty($positionPropertyArray['registration'])) {
                        $propertyPath = $propertyPath . '.registration';

                        $propertyMappingConfiguration->forProperty($propertyPath)->allowProperties('public');
                        $propertyMappingConfiguration->forProperty($propertyPath)->allowProperties('close');
                        $propertyMappingConfiguration->forProperty($propertyPath)->allowProperties('message');
                        $propertyMappingConfiguration->forProperty($propertyPath)->allowProperties('slots');
                        $propertyMappingConfiguration->allowCreationForSubProperty($propertyPath);
                        $propertyMappingConfiguration->allowModificationForSubProperty($propertyPath);
                    }

                    if (!empty($positionPropertyArray['files'])) {

                        $filesPropertyPath = 'appointments.' . $positionIndex;
                        $filesPropertyPath = $filesPropertyPath . '.files';


                        $propertyMappingConfiguration->forProperty($filesPropertyPath)->allowAllProperties();
                        $propertyMappingConfiguration->allowCreationForSubProperty($filesPropertyPath);
                        $propertyMappingConfiguration->allowModificationForSubProperty($filesPropertyPath);

                        foreach ($positionPropertyArray['files'] as $filePositionIndex => $filePositionPropertyArray) {
                            $filePropertyPath = $filesPropertyPath . '.' . $filePositionIndex;
                            $propertyMappingConfiguration->forProperty($filePropertyPath)->allowAllProperties();
                            $propertyMappingConfiguration
                                ->forProperty($filePropertyPath)
                                ->setTypeConverter(new \Bermuda\BssEvents\Converter\FileReferenceConverter());
                            $propertyMappingConfiguration->allowCreationForSubProperty($filePropertyPath);
                            $propertyMappingConfiguration->allowModificationForSubProperty($filePropertyPath);
                        }

                    }
                }
            }
        }
    }


    /**
     * @param \Bermuda\BssEvents\Domain\Model\Event $event
     * @param bool $save
     * @return \TYPO3\CMS\Extbase\Mvc\View\ViewInterface
     */
    public function editAction($event = null, $save = false)
    {
        /* Handle FrontendUser rights */
        /** @var FrontendUser|null $user */
        $user = $this->feUserRepo->findByUid(
            $GLOBALS['TSFE']->fe_user->user['uid']
        );

        // check if user is the event creator
        if ($event->getCreatorUid() == $GLOBALS['TSFE']->fe_user->user['uid']) {
            $isCreator = true;
        } else {
            $isCreator = false;
        }

        try {
            $isModerator = $user->getUsergroup()->contains(
                $this->feUserGroupRepo->findByUid(
                    $this->settings['moderatorGid']
                )
            );
        } catch (\Error $e) {
            $isModerator = false;
        }

        if (!($isCreator || $isModerator)) {
            $this->addFlashMessage('', LocalizationUtility::translate("LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_event.no_rights"), AbstractMessage::ERROR);
            return $this->redirect('show');
        }


        if (!$save) {
            //$this->handleRecurringAppointments($event);
            // new
            $this->view->assign('newEvent', $event);
            $this->view->assign('language', $GLOBALS['TSFE']->sys_language_isocode);
            $this->view->assign('categories', $this->categoryRepository->findAll());
        } else {

            $this->updateRecurringAppointments($event);
            // set recurringdate states
            if ($_POST['activeRecurringAppointments']) {
                $activeRecurring = array_map('intval', array_values($_POST['activeRecurringAppointments']));
                foreach ($event->getAppointments() as $appointment) {
                    /** @var Appointment $child */
                    foreach ($appointment->getChilds() as $child) {
                        if (in_array($child->getUid(), $activeRecurring)) {
                            $child->setActive(true);
                        } else {
                            $child->setActive(false);
                        }
                    }
                }
            }

            // save edited to repository
            $this->eventRepository->update($event);
            $this->addFlashMessage('', LocalizationUtility::translate("LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_event.edit_success"), AbstractMessage::OK);
            $this->redirect('show');
        }

        if ($_POST['ajax']) {
            // ajax view call back
            header('Content-Type: application/json');
            echo json_encode(['error' => false, 'message' => $this->view->render()]);
            die;
        }


        // implicit view call back of ActionController
    }


    /**
     * @param \Bermuda\BssEvents\Domain\Model\Subscriber $subscriber
     * @param bool $updatedata
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     */
    public function subscribeAction(Subscriber $subscriber, $updatedata = false)
    {

        $error = false;
        $message = LocalizationUtility::translate("LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_subscriber.success");

        /** @var FrontendUser|null $user */
        $user = $this->feUserRepo->findByUid($GLOBALS['TSFE']->fe_user->user['uid']);

        if ($user != null)
            $subscriber->setCreator($user);

        try {
            $this->subscriberRepository->add($subscriber);
            if ($updatedata) {
                $this->sendUpdateMailRequest($subscriber);
            }
        } catch (\Exception $e) {
            $message = LocalizationUtility::translate("LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_subscriber.error", "bss_events");
            $error = true;
        }

        // @TODO: fix check for ajax, actually only ajax works
        if (!$_POST['ajax']) {

            $this->persistenceManager->persistAll();

            header('Content-Type: application/json');
            echo json_encode(['error' => $error ? true : false, 'message' => $message]);
            die;
        } else {
            $this->addFlashMessage($message, '', $error ? AbstractMessage::ERROR : AbstractMessage::OK);
            $this->redirect('show');
        }
    }

    /**
     * @param Subscriber $subscriber
     */
    private function sendUpdateMailRequest($subscriber)
    {
        if ($this->settings['bssEvents']['main']['email_subject'] == '') {
            $subject = "Update User Data Request";
        }else {
            $subject = $this->settings['bssEvents']['main']['email_subject'];
        }

        $email = $this->settings['bssEvents']['main']['email'];

        $text = "\n";

        $text .= "Firstname: {$subscriber->getFirstname()}\n";
        $text .= "Lastname: {$subscriber->getLastname()}\n";
        $text .= "Email: {$subscriber->getEmail()}\n";
        $text .= "Phone: {$subscriber->getPhone()}\n";
        $text .= "Street: {$subscriber->getStreet()}\n";
        $text .= "ZIP: {$subscriber->getZip()}\n";
        $text .= "City: {$subscriber->getCity()}\n";
        $text .= "Message: {$subscriber->getMessage()}\n";

        if ($email != ''){
            mail($email, $subject, $text);
        }
    }

    /**
     * @param Appointment $appointment
     * @return Error
     */
    public function exportAction(Appointment $appointment)
    {
        /* Handle FrontendUser rights */
        /** @var FrontendUser|null $user */
        $user = $this->feUserRepo->findByUid(
            $GLOBALS['TSFE']->fe_user->user['uid']
        );
        $isCreator = $user->getUsergroup()->contains(
            $this->feUserGroupRepo->findByUid(
                $this->settings['creatorGid']
            )
        );
        $isModerator = $user->getUsergroup()->contains(
            $this->feUserGroupRepo->findByUid(
                $this->settings['moderatorGid']
            )
        );

        if (!($isCreator || $isModerator))
            return new \TYPO3\CMS\Extbase\Error\Error('Not permitted to access participant excel file!', 139954);


        $tmpArr = [];


        $tmpArr = [];
        foreach ($appointment->getSubscribers() as $subscriber) {
            $tmpArr[] = $subscriber->toArray();
        };


        // Create new PHPExcel object
        $objPHPExcel = new \PHPExcel();
        $name = $appointment->getEvent()->getTitle() . ' - Participant Export';

        $objPHPExcel->getProperties()
            ->setTitle($name)
            ->setSubject("Bermuda Software Solutions GmbH");

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Firstname')
            ->setCellValue('B1', 'Lastname')
            ->setCellValue('C1', 'Mail')
            ->setCellValue('D1', 'Phone')
            ->setCellValue('E1', 'Street')
            ->setCellValue('F1', 'ZIP')
            ->setCellValue('G1', 'City')
            ->setCellValue('H1', 'Message');

        $objPHPExcel->getActiveSheet()->fromArray($tmpArr, null, 'A3');
        unset($tmp);

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);


        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $name . '.xls"');
        header('Cache-Control: max-age=0');

        header('Cache-Control: max-age=1');

        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;

    }

    /**
     * Updates recurring appointments by event reference
     *
     * @param Event $event
     * @return void
     */
    private function createRecurringAppointments(&$event)
    {

        try {
            $endDateTime = (new \DateTime)->add(new \DateInterval('P' . $this->settings['creationSpan'] . 'D'));
        } catch (\Exception $e) {
            $endDateTime = (new \DateTime)->add(new \DateInterval('P365D'));
        }

        /** @var Appointment $appointment */
        foreach ($event->getAppointments() as $appointment) {
            if ($appointment->getParent() == null && $appointment->isRepeatWeekly() == true) {

                $recStartDate = clone $appointment->getDateFrom();
                $recEndDate = clone $appointment->getDateTo();

                $recStartDate->add(new \DateInterval('P1W'));
                $recEndDate->add(new \DateInterval('P1W'));

                while ($recStartDate <= $endDateTime) :

                    $newAppointment = new Appointment();
                    $newAppointment->setEvent($appointment->getEvent());
                    $newAppointment->setParent($appointment);
                    $newAppointment->setState('active');
                    $newAppointment->setDateFrom(clone $recStartDate);
                    $newAppointment->setDateTo(clone $recEndDate);
                    if (is_object($appointment->getRegistration()))
                        $newAppointment->setRegistration(clone $appointment->getRegistration());

                    $appointment->addChild($newAppointment);

                    $recStartDate = $recStartDate->add(new \DateInterval('P1W'));
                    $recEndDate = $recEndDate->add(new \DateInterval('P1W'));

                endwhile;
            }
        }
    }

    /**
     * Updates recurring appointments by event reference
     *
     * @param Event $event
     * @return void
     */
    private function updateRecurringAppointments(&$event)
    {

        /** @var Appointment $appointment */
        foreach ($event->getAppointments() as $appointment) {
            if ($appointment->getParent() == null && $appointment->isRepeatWeekly() == true) {

                $recStartDate = clone $appointment->getDateFrom();
                $recEndDate = clone $appointment->getDateTo();

                $recStartDate->add(new \DateInterval('P1W'));
                $recEndDate->add(new \DateInterval('P1W'));

                while ($recStartDate <= (new \DateTime())) :

                    $recStartDate = $recStartDate->add(new \DateInterval('P1W'));
                    $recEndDate = $recEndDate->add(new \DateInterval('P1W'));

                endwhile;


                /** @var Appointment $child */
                foreach ($appointment->getChilds() as $child) {
                    if ($child->getDateFrom() > (new \DateTime())) {

                        if ($child->getDateFrom() != $recStartDate) {
                            $child->setRegistration(clone $appointment->getRegistration());
                        }

                        $child->setDateFrom(clone $recStartDate);
                        $child->setDateTo(clone $recEndDate);

                        $recStartDate = $recStartDate->add(new \DateInterval('P1W'));
                        $recEndDate = $recEndDate->add(new \DateInterval('P1W'));
                    }
                }
            }
        }
    }

    /**
     * Checks for allready existing appointment
     *
     * @param Event $event
     * @param \DateTime $start
     * @param \DateTime $end
     * @return bool
     */
    private function checkExistingAppointment($event, $start, $end)
    {
        /** @var Appointment $appointment */
        foreach ($event->getAppointments() as $appointment) {
            if ($appointment->getDateFrom() == $start && $appointment->getDateTo() == $end)
                return true;
        }
        return false;
    }

    /**
     *
     */
    protected function setTypeConverterConfigurationForImageUpload($argumentName)
    {
        $uploadConfiguration = [
            UploadedFileReferenceConverter::CONFIGURATION_ALLOWED_FILE_EXTENSIONS => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
            UploadedFileReferenceConverter::CONFIGURATION_UPLOAD_FOLDER => '1:/user_upload/',
        ];
        /** @var PropertyMappingConfiguration $newImageConfiguration */
        $newImageConfiguration = $this->arguments[$argumentName]->getPropertyMappingConfiguration();

        $newImageConfiguration->forProperty('image.0')
            ->setTypeConverterOptions(
                'Bermuda\\BssEvents\\Property\\TypeConverter\\UploadedFileReferenceConverter',
                $uploadConfiguration
            );
    }

}