<?php

namespace Bermuda\BssEvents\Domain\Model;

class Subscriber extends AbstractModel
{

    /**
     * @var string
     **/
    protected $firstname = '';

    /**
     * @var string
     **/
    protected $lastname = '';

    /**
     * @var string
     **/
    protected $email = '';

    /**
     * @var string
     **/
    protected $phone = '';

    /**
     * @var string
     **/
    protected $street = '';

    /**
     * @var string
     **/
    protected $zip = '';

    /**
     * @var string
     **/
    protected $city = '';

    /**
     * @var string
     **/
    protected $message = '';


    /**
     * @var \Bermuda\BssEvents\Domain\Model\Appointment
     **/
    protected $appointment = null;

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser|null
     **/
    protected $creator = null;

    /** @var \Bermuda\BssEvents\Domain\Repository\SubscriberRepository
     * @inject
     */
    protected $repository;


    /**
     * Subscriber constructor.
     * @param string $firstname
     * @param string $lastname
     * @param string $email
     * @param string $phone
     * @param string $street
     * @param string $zip
     * @param string $city
     * @param string $message
     * @param \Bermuda\BssEvents\Domain\Model\Appointment $appointment
     */
    public function __construct($firstname, $lastname, $email, $phone, $street, $zip, $city, $message, $appointment)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->phone = $phone;
        $this->street = $street;
        $this->zip = $zip;
        $this->city = $city;
        $this->message = $message;
        $this->appointment = $appointment;

        // @TODO: handling creator variable in constructor???
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
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
     * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser|null
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser|null $creator
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;
    }

    public function toArray(){
        $arr[] = $this->firstname;
        $arr[] = $this->lastname;
        $arr[] = $this->email;
        $arr[] = $this->phone;
        $arr[] = $this->street;
        $arr[] = $this->zip;
        $arr[] = $this->city;
        $arr[] = $this->message;
        return $arr;
    }


}