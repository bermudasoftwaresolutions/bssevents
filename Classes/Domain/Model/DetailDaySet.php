<?php

namespace Bermuda\BssEvents\Domain\Model;


use IntlDateFormatter;

class DetailDaySet extends Month
{

    protected $isDayDetail = true;

    /**
     * Month constructor.
     * @param array $args
     * @param array|null $settings
     */
    public function initialize($args, $settings = null)
    {

        if ($args['cat']){
            $this->cat = intval($args['cat']);
        }

        // define year, month & style from arguments
        $time = strtotime($args['dayString']);
        $this->month = intval(date("n", $time));
        $this->year = intval(date("Y", $time));
        $this->style = $args['style'];

        // define month range
        $this->monthString = $args['dayString'];
        $this->days = 1;
        $this->start = date_create_from_format('Y-m-d H:i:s', $this->monthString . ' 00:00:00');
        $this->end = date_create_from_format('Y-m-d H:i:s', $this->monthString . ' 23:59:59');

        $day = intval(date("d", $time));

        $this->daysArr[0] = new Day(
            $this->year,
            $this->month,
            $day,
            $this->appointmentRepository->findByDateRange($this->year, $this->month, $day, 'disabled', $this->cat)
        );
    }


    /**
     * translated title for month
     *
     * @return string
     */
    public function getTitle()
    {
        $format = new IntlDateFormatter($GLOBALS['TSFE']->sys_language_isocode, IntlDateFormatter::NONE,
            IntlDateFormatter::NONE, NULL, NULL, "EEEE, d. MMMM yyyy");
        return datefmt_format($format, mktime(0, 0, 0, $this->month, $this->daysArr[0]->getDay(), $this->year));
    }

    public function getIsDayDetail(){
        return $this->isDayDetail;
    }

    /**
     * @return int
     */
    public function getCat()
    {
        return $this->cat;
    }
}