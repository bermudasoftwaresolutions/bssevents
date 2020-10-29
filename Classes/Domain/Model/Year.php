<?php

namespace Bermuda\BssEvents\Domain\Model;


use IntlDateFormatter;

class Year extends AbstractModel
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
    protected $yearString = '';

    /**
     * @var int
     **/
    protected $year = 0;

    /**
     * @var int
     **/
    protected $days = 0;

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

            $time = strtotime($args['date'].'-1-1');
            if ($args['year'] === 'next') {
                $time = strtotime("+1 year", $time);
            } elseif ($args['year'] === 'prev'){
                $time = strtotime("-1 year", $time);
            }
            $this->year = intval(date("Y", $time));
            $this->style = 'yearlist';
        } else {
            $this->year = date("Y");
            $this->style = $settings['main']['output'];
        }

        // define month range
        $this->yearString = $this->year;
        $this->days = date('L', strtotime($this->year.'-1-1')) == 1 ? 366 : 365;
        $this->start = date_create_from_format('Y-m-d H:i:s', $this->year.'-1-1 00:00:00');
        $this->end = date_create_from_format('Y-m-d H:i:s', $this->year.'-12-31 23:59:59');

        // get matching appointments
        //** @var Appointment $item */
        foreach ($this->appointmentRepository->findByMonthRange($this->start, $this->end, 'disabled', $this->cat) as $item) {
            $this->appointments->attach($item);
        }
    }


    /**
     * translated title for month
     *
     * @return string
     */
    public function getTitle()
    {
        /*$format = new IntlDateFormatter($GLOBALS['TSFE']->sys_language_isocode, IntlDateFormatter::NONE,
            IntlDateFormatter::NONE, NULL, NULL, "MMMM");
        $monthName = datefmt_format($format, mktime(0, 0, 0, $this->month));*/

        return $this->year;
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
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getAppointments()
    {
        return $this->appointments;
    }

    /**
     * @return string
     */
    public function getYearString()
    {
        return $this->yearString;
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @return int
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @return int
     */
    public function getCat()
    {
        return $this->cat;
    }

}