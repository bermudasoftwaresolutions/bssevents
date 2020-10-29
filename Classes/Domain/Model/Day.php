<?php

namespace Bermuda\BssEvents\Domain\Model;


use IntlDateFormatter;

class Day extends AbstractModel
{

    /**
     * @var string
     */
    protected $title;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bermuda\BssEvents\Domain\Model\Appointment> The appointments of the day
     */
    protected $appointments;

    /**
     * @var int
     */
    protected $count;

    /**
     * @var int
     */
    protected $day;

    /**
     * @var string|bool
     */
    protected $color;

    /**
     * @var string
     */
    protected $dateString;

    /**
     * @var Appointment
     */
    protected $firstAppointment;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bermuda\BssEvents\Domain\Model\Appointment> The appointments of the day excepting first
     */
    protected $moreAppointments;


    /**
     * Day constructor.
     * @param $year
     * @param $month
     * @param $day
     * @param $appointments
     */
    public function __construct($year, $month, $day, $appointments)
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();

        foreach ($appointments as $appointment) {
            $this->appointments->attach($appointment);
        }

        $this->count = $this->appointments->count();

        try{
            $this->color = $this->appointments->toArray()[0]->getEvent()->getCategories()->toArray()[0]->getColor();
        }catch(\Error $e){
            $this->color = false;
        }

        $this->day = $day;

        $this->dateString =  $year . '-' . $month . '-' . $day;

        $format = new IntlDateFormatter($GLOBALS['TSFE']->sys_language_isocode, IntlDateFormatter::NONE,
                IntlDateFormatter::NONE, NULL, NULL, "EEEE");
        $this->title = $day . '. ' . datefmt_format($format, mktime(0, 0, 0, $month, $day, $year));
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
        $this->appointments = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getAppointments()
    {
        return $this->appointments;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @return bool|string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return Appointment|null
     */
    public function getFirstAppointment(){
        return $this->appointments->toArray()[0];
    }

    /**
     * @return string
     */
    public function getDateString()
    {
        return $this->dateString;
    }

    public function getMoreAppointments(){
        $clone = clone $this->appointments;
        $clone->detach($this->getFirstAppointment());
        return $clone;
    }

    /**
     * @return int
     */
    public function getDay(){
        return $this->day;
    }



}