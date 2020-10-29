<?php

namespace Bermuda\BssEvents\Domain\Model;


use IntlDateFormatter;

class Appointment extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * dateFrom
     *
     * @var \DateTime
     * @validate NotEmpty
     */
    protected $dateFrom = null;

    /**
     * dateTo
     *
     * @var \DateTime
     * @validate NotEmpty
     */
    protected $dateTo = null;

    /**
     * @var string
     **/
    protected $state = '';

    /**
     * @var string
     **/
    protected $color = '';

    /**
     * @var \Bermuda\BssEvents\Domain\Model\Event
     **/
    protected $event = null;

    /**
     * @var \Bermuda\BssEvents\Domain\Model\Registration|null
     * @cascade remove
     **/
    protected $registration = null;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bermuda\BssEvents\Domain\Model\Subscriber>
     * @cascade remove
     **/
    protected $subscribers = null;

    /**
     * @var bool
     **/
    protected $repeatWeekly = false;

    /**
     * @var bool
     **/
    protected $active = true;

    /**
     * @var \Bermuda\BssEvents\Domain\Model\Appointment
     **/
    protected $parent = null;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bermuda\BssEvents\Domain\Model\Appointment>
     **/
    protected $childs = null;


    /** @var \Bermuda\BssEvents\Domain\Repository\AppointmentRepository
     * @inject
     */
    protected $repository;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bermuda\BssEvents\Domain\Model\AppointmentFileReference>
     * @cascade remove
     */
    protected $files = null;


    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }


    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->subscribers = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->childs = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->files = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }


    /**
     * @return \DateTime
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * @param \DateTime $dateFrom
     * @return void
     */
    public function setDateFrom($dateFrom)
    {
        $this->dateFrom = $dateFrom;
    }

    /**
     * @return \DateTime
     */
    public function getDateTo()
    {
        return $this->dateTo;
    }

    /**
     * @param \DateTime $dateTo
     * @return void
     */
    public function setDateTo($dateTo)
    {
        $this->dateTo = $dateTo;
    }

    /**
     * @return string
     */
    public function getState()
    {
        if($this->state == 'active' && $this->dateFrom < new \DateTime()){
            return 'archived';
        }

        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getSubscribers()
    {
        return $this->subscribers;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $subscribers
     */
    public function setSubscribers($subscribers)
    {
        $this->subscribers = $subscribers;
    }

    /**
     * @return Event
     */
    public function getEvent()
    {
        if(is_object($this->parent)){
            return $this->parent->getEvent();
        }else{
            return $this->event;
        }
    }

    /**
     * @param Event $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }

    /**
     * @return string
     */
    public function getColor(){
        try{
            return $this->getEvent()->getCategories()->toArray()[0]->getColor();
        }catch(\Error $e){
            return 'red';
        }
    }

    /**
     * @return Registration|null
     */
    public function getRegistration()
    {
        return $this->registration;
    }

    /**
     * @param Registration|null $registration
     */
    public function setRegistration($registration)
    {
        $this->registration = $registration;
    }

    /**
     * @return bool
     */
    public function isRepeatWeekly()
    {
        return $this->repeatWeekly;
    }

    /**
     * @param bool $repeatWeekly
     */
    public function setRepeatWeekly($repeatWeekly)
    {
        $this->repeatWeekly = $repeatWeekly;
    }

    /**
     * @return Appointment|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Appointment $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getChilds()
    {
        return $this->childs;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $childs
     */
    public function setChilds($childs)
    {
        $this->childs = $childs;
    }


    /**
     * @param Appointment $child
     */
    public function addChild(\Bermuda\BssEvents\Domain\Model\Appointment $child)
    {
        $this->childs->attach($child);
    }


    /**
     * @param Appointment $child
     */
    public function removeChild(\Bermuda\BssEvents\Domain\Model\Appointment $child)
    {
        $this->childs->detach($child);
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    public function getListTitle(){
        $format = new IntlDateFormatter($GLOBALS['TSFE']->languageService->lang, IntlDateFormatter::NONE,
            IntlDateFormatter::NONE, NULL, NULL, "EEEE");


        return datefmt_format($format, strtotime(date('Y-m-d', $this->dateFrom->getTimestamp()))).','.date(' d.m.Y', $this->dateFrom->getTimestamp()).' - '.datefmt_format($format, strtotime(date('Y-m-d', $this->dateTo->getTimestamp()))).','.date(' d.m.Y', $this->dateTo->getTimestamp());
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $files
     */
    public function setFiles($files)
    {
        $this->files = $files;
    }

    /**
     * @param \Bermuda\BssEvents\Domain\Model\AppointmentFileReference $file
     */
    public function addFile($file){
        $this->files->attach($file);
    }

    /**
     * @param \Bermuda\BssEvents\Domain\Model\AppointmentFileReference $file
     */
    public function removeFile($file){
        $this->files->detach($file);
    }

}