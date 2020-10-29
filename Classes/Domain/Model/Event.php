<?php

namespace Bermuda\BssEvents\Domain\Model;


use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Event extends AbstractModel
{

    /**
     * @var string
     **/
    protected $title = '';

    /**
     * @var string
     **/
    protected $place = '';

    /**
     * @var string
     **/
    protected $organizer = '';

    /**
     * @var string
     **/
    protected $body = '';

    /**
     * @var string
     **/
    protected $state = '';

    /**
     * @var int
     **/
    protected $creatorUid = 0;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bermuda\BssEvents\Domain\Model\Category> The categories of the event
     */
    protected $categories;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bermuda\BssEvents\Domain\Model\Appointment> The appointments of the event
     * @cascade remove
     */
    protected $appointments;

    /** @var \Bermuda\BssEvents\Domain\Repository\EventRepository
     * @inject
     */
    protected $repository;

    /**
     * image
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    protected $image;


    /**
     * Event constructor.
     * @param string $title
     * @param string $place
     * @param string $organizer
     * @param string $body
     * @param string $state
     */
    public function __construct($title = '', $place = '', $organizer = '', $body = '', $state = '')
    {
        $this->initStorageObjects();
        $this->title = $title;
        $this->place = $place;
        $this->organizer = $organizer;
        $this->body = $body;
        $this->state = $state;
    }

    protected function initStorageObjects()
    {
        $this->categories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->appointments = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->image = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }


    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param string $place
     */
    public function setPlace($place)
    {
        $this->place = $place;
    }

    /**
     * @return string
     */
    public function getOrganizer()
    {
        return $this->organizer;
    }

    /**
     * @param string $organizer
     */
    public function setOrganizer($organizer)
    {
        $this->organizer = $organizer;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getPreviewBody()
    {
        return strip_tags($this->body, '<br><br/>');
    }

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }


    /**
     * @return string
     */
    public function getState()
    {
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
     * @return int
     */
    public function getCreatorUid()
    {
        return $this->creatorUid;
    }

    /**
     * @param int $creatorUid
     */
    public function setCreatorUid($creatorUid)
    {
        $this->creatorUid = $creatorUid;
    }

    /**
     * Adds a category to the event
     *
     * @param \Bermuda\BssEvents\Domain\Model\Category The category to be added
     * @return void
     */
    public function addCategory(\Bermuda\BssEvents\Domain\Model\Category $category)
    {
        if ($this->categories == null) {
            $this->categories = $this->objectManager->get(ObjectStorage::class);
        }
        $this->categories->attach($category);
        $this->save();
    }

    /**
     * Sets the categories of the event
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories
     * @return void
     */
    public function setCategories(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories)
    {
        $this->categories = $categories;
        $this->save();
    }

    /**
     * Removes a category of the event
     *
     * @param \Bermuda\BssEvents\Domain\Model\Category The category to be removed
     * @return void
     */
    public function removeCategory(\Bermuda\BssEvents\Domain\Model\Category $category)
    {
        if ($this->categories != null) {
            $this->categories->detach($category);
            $this->save();
        }
    }

    /**
     * Returns the categories of the event
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bermuda\BssEvents\Domain\Model\Category> The categories of the event
     */
    public function getCategories()
    {
        return clone $this->categories;
    }

    /**
     * Adds a appointment to the event
     *
     * @param \Bermuda\BssEvents\Domain\Model\Appointment The category to be added
     * @return void
     */
    public function addAppointment(\Bermuda\BssEvents\Domain\Model\Appointment $appointment)
    {
        if ($this->appointments == null) {
            $this->appointments = $this->objectManager->get(ObjectStorage::class);
        }
        $this->appointments->attach($appointment);
        $this->save();
    }

    /**
     * Sets the appointments of the event
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $appointments
     * @return void
     */
    public function setAppointments(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $appointments)
    {
        $this->appointments = $appointments;
        $this->save();
    }

    /**
     * Removes a appointment of the event
     *
     * @param \Bermuda\BssEvents\Domain\Model\Appointment The Appointment to be removed
     * @return void
     */
    public function removeAppointment(\Bermuda\BssEvents\Domain\Model\Appointment $appointment)
    {
        if ($this->appointments != null) {
            $this->appointments->detach($appointment);
            $this->save();
        }
    }

    /**
     * Returns the Appointments of the event
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bermuda\BssEvents\Domain\Model\Appointment> The appointments of the event
     */
    public function getAppointments()
    {
        return $this->appointments;
    }

    /**
     * Adds a FileReference
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     * @return void
     */
    public function addImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image)
    {
        $this->image->attach($image);
    }

    /**
     * Removes a FileReference
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $imageToRemove The FileReference to be removed
     * @return void
     */
    public function removeImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $imageToRemove)
    {
        $this->image->detach($imageToRemove);
    }

    /**
     * Sets the image
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $image
     * @return void
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Returns the image
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getImage()
    {
        return $this->image;
    }

}