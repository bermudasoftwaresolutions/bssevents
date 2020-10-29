<?php

namespace Bermuda\BssEvents\Domain\Model;


use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Category extends AbstractModel
{

    /**
     * @var string
     **/
    protected $title = '';

    /**
     * @var string
     **/
    protected $color = '';

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bermuda\BssEvents\Domain\Model\Event> The events of the category
     * @lazy
     */
    protected $events;

    /** @var \Bermuda\BssEvents\Domain\Repository\CategoryRepository
     * @inject
     */
    protected $repository;


    /**
     * Category constructor.
     * @param string $title
     * @param string $color
     */
    public function __construct($title, $color)
    {
        $this->title = $title;
        $this->color = $color;
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
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * Adds an event of the category
     *
     * @param \Bermuda\BssEvents\Domain\Model\Event The event to be added
     * @return void
     */
    public function addEvent(\Bermuda\BssEvents\Domain\Model\Event $event) {
        if ($this->events == null) {
            $this->events = $this->objectManager->get(ObjectStorage::class);
        }
        $this->events->attach($event);
        $this->save();
    }

    /**
     * Sets the events of the category
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $events
     * @return void
     */
    public function setEvents(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $events) {
        $this->events = $events;
        $this->save();
    }

    /**
     * Removes an event of the category
     *
     * @param \Bermuda\BssEvents\Domain\Model\Event The event to be removed
     * @return void
     */
    public function removeEvent(\Bermuda\BssEvents\Domain\Model\Event $event) {
        if ($this->events != null) {
            $this->events->detach($event);
            $this->save();
        }
    }

    /**
     * Returns the events of the category
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bermuda\BssEvents\Domain\Model\Event> The events of the category
     */
    public function getEvents() {
        return $this->events;
    }


}