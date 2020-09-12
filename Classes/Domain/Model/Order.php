<?php
namespace Bermuda\BssShop\Domain\Model;


/***
 *
 * This file is part of the "Bss Shop" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Bermuda Software <info@bermuda-software.ch>, Bermuda Software
 *
 ***/
/**
 * Order
 */
class Order extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * number
     * 
     * @var string
     */
    protected $number = '';

    /**
     * message
     * 
     * @var string
     */
    protected $message = '';

    /**
     * status
     *
     * @var string
     */
    protected $status = '';


    /**
     * total
     * 
     * @var float
     */
    protected $total = 0.0;

    /**
     * merchantAddress
     * 
     * @var string
     */
    protected $merchantAddress = '';

    /**
     * clientAddress
     * 
     * @var string
     */
    protected $clientAddress = '';

    /**
     * client
     * 
     * @var \Bermuda\BssShop\Domain\Model\Client
     */
    protected $client = null;

    /**
     * orderitems
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bermuda\BssShop\Domain\Model\OrderItem>
     * @cascade remove
     */
    protected $orderitems = null;

    /**
     * orderStatus
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bermuda\BssShop\Domain\Model\OrderStatus>
     * @cascade remove
     */
    protected $orderStatus = null;

    /**
     *
     * @var \DateTime
     */
    protected $tstamp;


    /**
     * Returns tstamp
     *
     * @return \DateTime
     */
    public function getTstamp() {
        return $this->tstamp;
    }

    /**
     *
     * @var \DateTime
     */
    protected $crdate;


    /**
     * Returns crdate
     *
     * @return \DateTime
     */
    public function getCrdate() {
        return $this->crdate;
    }

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
        $this->orderitems = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the number
     * 
     * @return string $number
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Sets the number
     * 
     * @param string $number
     * @return void
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * Returns the message
     * 
     * @return string $message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Sets the message
     * 
     * @param string $message
     * @return void
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Returns the status
     *
     * @return string $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Sets the status
     *
     * @param string $status
     * @return void
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Returns the total
     * 
     * @return float $total
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Sets the total
     * 
     * @param float $total
     * @return void
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * Returns the merchantAddress
     * 
     * @return string $merchantAddress
     */
    public function getMerchantAddress()
    {
        return $this->merchantAddress;
    }

    /**
     * Sets the merchantAddress
     * 
     * @param string $merchantAddress
     * @return void
     */
    public function setMerchantAddress($merchantAddress)
    {
        $this->merchantAddress = $merchantAddress;
    }

    /**
     * Returns the clientAddress
     * 
     * @return string $clientAddress
     */
    public function getClientAddress()
    {
        return $this->clientAddress;
    }

    /**
     * Sets the clientAddress
     * 
     * @param string $clientAddress
     * @return void
     */
    public function setClientAddress($clientAddress)
    {
        $this->clientAddress = $clientAddress;
    }

    /**
     * Returns the client
     * 
     * @return \Bermuda\BssShop\Domain\Model\Client $client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Sets the client
     * 
     * @param \Bermuda\BssShop\Domain\Model\Client $client
     * @return void
     */
    public function setClient(\Bermuda\BssShop\Domain\Model\Client $client)
    {
        $this->client = $client;
    }

    /**
     * Adds a OrderItem
     * 
     * @param \Bermuda\BssShop\Domain\Model\OrderItem $orderitem
     * @return void
     */
    public function addOrderitem(\Bermuda\BssShop\Domain\Model\OrderItem $orderitem)
    {
        $this->orderitems->attach($orderitem);
    }

    /**
     * Removes a OrderItem
     * 
     * @param \Bermuda\BssShop\Domain\Model\OrderItem $orderitemToRemove The OrderItem to be removed
     * @return void
     */
    public function removeOrderitem(\Bermuda\BssShop\Domain\Model\OrderItem $orderitemToRemove)
    {
        $this->orderitems->detach($orderitemToRemove);
    }

    /**
     * Returns the orderitems
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bermuda\BssShop\Domain\Model\OrderItem> $orderitems
     */
    public function getOrderitems()
    {
        return $this->orderitems;
    }

    /**
     * Sets the orderitems
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bermuda\BssShop\Domain\Model\OrderItem> $orderitems
     * @return void
     */
    public function setOrderitems(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $orderitems)
    {
        $this->orderitems = $orderitems;
    }


    /**
     * Returns the orderStatus
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bermuda\BssShop\Domain\Model\OrderStatus> $orderStatus
     */
    public function getOrderStatus()
    {
        return $this->orderStatus;
    }

    /**
     * Sets the orderStatus
     *
     * @param \Bermuda\BssShop\Domain\Model\OrderStatus $orderStatus $orderStatus
     * @return void
     */
    public function setOrderStatus(\Bermuda\BssShop\Domain\Model\OrderStatus $orderStatus)
    {
        $this->orderStatus = $orderStatus;
    }


}
