<?php

namespace Bermuda\BssEvents\Domain\Model;


use IntlDateFormatter;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class Month extends AbstractModel
{

    /**
     * @var int
     **/
    protected $cat = 0;

    /**
     * @var string
     **/
    protected $title = '';

    /**
     * @var string
     **/
    protected $style = '';

    /**
     * @var string
     **/
    protected $monthString = '';

    /**
     * @var int
     **/
    protected $month = 0;

    /**
     * @var int
     **/
    protected $year = 0;

    /**
     * @var int
     **/
    protected $days = 0;

    /**
     * @var array
     **/
    protected $daysArr = [];

    /**
     * @var \DateTime
     **/
    protected $start = null;

    /**
     * @var \DateTime
     **/
    protected $end = null;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bermuda\BssEvents\Domain\Model\Appointment> The appointments of the event
     */
    protected $appointments;

    /** @var \Bermuda\BssEvents\Domain\Repository\AppointmentRepository
     * @inject
     */
    protected $appointmentRepository;

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
        $this->appointments = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Month constructor.
     * @param array $args
     * @param array $settings
     */
    public function initialize($args, $settings)
    {

        if ($args['cat']){
            $this->cat = intval($args['cat']);
        }

        // define year, month & style from arguments
        if ($args['date']) {

            $time = strtotime($args['date']);
            if ($args['month'] === 'next') {
                $time = strtotime("+1 month", $time);
            } elseif ($args['month'] === 'prev'){
                $time = strtotime("-1 month", $time);
            }
            $this->month = intval(date("n", $time));
            $this->year = intval(date("Y", $time));
            $this->style = $args['style'];
        } else {
            $this->month = date("n");
            $this->year = date("Y");
            $this->style = $settings['main']['output'];
        }

        // define month range
        $this->monthString = $this->year.'-'.$this->month.'-1';
        $this->days = intval(date('t', strtotime($this->year.'-'.$this->month.'-1')));
        $this->start = date_create_from_format('Y-m-d H:i:s', $this->year.'-'.$this->month.'-1 00:00:00');
        $this->end = date_create_from_format('Y-m-d H:i:s', $this->year.'-'.$this->month.'-'.$this->days.' 23:59:59');

        // get matching appointments
        //** @var Appointment $item */
        /*
        foreach ($this->appointmentRepository->findByMonthRange($this->start, $this->end) as $item) {
            $this->appointments->attach($item);
        }*/

        for ($i=1;$i<=$this->days;$i++){
            $this->daysArr[$i] = $this->createDay($i);
        }

    }


    /**
     * translated title for month
     *
     * @return string
     */
    public function getTitle()
    {
        $month = $this->month;
        $monthName = LocalizationUtility::translate("LLL:EXT:bss_events/Resources/Private/Language/locallang_db.xlf:tx_bssevents_event.months.$month", "bss_events");

        return $monthName . ' ' . $this->year;
    }

    /**
     * array with all days filled with appointments
     *
     * @return array
     */
    public function getDays(){
        return $this->daysArr;
    }

    /**
     * style for rendering
     *
     * @return string
     */
    public function getStyle(){
        return $this->style;
    }

    /**
     * starting date of actual month
     *
     * @return \DateTime
     */
    public function getStart(){
        return $this->start;
    }

    /**
     * @return string
     */
    public function getMonthString()
    {
        return $this->monthString;
    }

    private function createDay($i){
        return new Day(
            $this->year,
            $this->month,
            $i,
            $this->appointmentRepository->findByDateRange($this->year, $this->month, $i, 'disabled', $this->cat)
        );
    }

    /**
     * @return int
     */
    public function getCat()
    {
        return $this->cat;
    }

}