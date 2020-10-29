<?php

namespace Bermuda\BssEvents\Domain\Model;

class Registration extends AbstractModel
{
    /**
     * @var bool
     **/
    protected $public = false;

    /**
     * @var bool
     **/
    protected $close = false;

    /**
     * @var string
     **/
    protected $message = '';

    /**
     * @var \Bermuda\BssEvents\Domain\Model\Appointment
     **/
    protected $appointment = null;

    /**
     * slots
     *
     * @var int
     */
    protected $slots = null;


    /**
     * @return bool
     */
    public function isPublic()
    {
        return $this->public;
    }

    /**
     * @return bool
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * @return bool
     */
    public function isClose()
    {
        return $this->close;
    }

    /**
     * @param bool $close
     */
    public function setClose($close)
    {
        $this->close = $close;
    }

    /**
     * @param bool $public
     */
    public function setPublic($public)
    {
        $this->public = $public;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return \Bermuda\BssEvents\Domain\Model\Appointment
     */
    public function getAppointment()
    {
        return $this->appointment;
    }

    /**
     * @param \Bermuda\BssEvents\Domain\Model\Appointment $appointment
     */
    public function setAppointment($appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Returns the slots
     *
     * @return string
     */
    public function getSlots()
    {
        return $this->slots;
    }

    /**
     * Sets the slots
     *
     * @param string
     *
     */
    public function setSlots($slots)
    {
        $this->slots = $slots;
    }

    public function getDo(){

        if($this->public)
            return true;

        if($GLOBALS['TSFE']->fe_user->user['uid'])
            return true;

        return false;
    }

    public function __clone(){
        $obj = new Registration();
        $obj->setPublic($this->getPublic());
        $obj->setMessage($this->getMessage());
        return $obj;
    }
}