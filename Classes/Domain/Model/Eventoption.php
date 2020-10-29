<?php

namespace Bermuda\BssEvents\Domain\Model;


class Eventoption extends AbstractModel
{

    /**
     * @var string
     **/
    protected $title = '';

    /**
     * @var string
     **/
    protected $type = '';

    /**
     * @var string
     **/
    protected $values = '';

    /**
     * @var string
     **/
    protected $selection = '';

    /** @var \Bermuda\BssEvents\Domain\Repository\EventoptionRepository
     * @inject
     */
    protected $repository;


    /**
     * Event constructor.
     * @param string $title
     * @param string $type
     * @param string $values
     * @param string $selection
     */
    public function __construct($title, $type, $values, $selection)
    {
        $this->title = $title;
        $this->type = $type;
        $this->values = $values;
        $this->selection = $selection;
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param string $values
     */
    public function setValues($values)
    {
        $this->values = $values;
    }

    /**
     * @return string
     */
    public function getSelection()
    {
        return $this->selection;
    }

    /**
     * @param string $selection
     */
    public function setSelection($selection)
    {
        $this->selection = $selection;
    }
}