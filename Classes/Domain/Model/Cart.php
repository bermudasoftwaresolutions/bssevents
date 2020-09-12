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
 * Cart
 */
class Cart extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * cartItemRepository
     *
     * @var \Bermuda\BssShop\Domain\Repository\CartItemRepository
     * @inject
     */
    protected $cartItemRepository = null;

    /**
     * total
     * 
     * @var float
     */
    protected $total = 0.0;

    /**
     * cartitems
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bermuda\BssShop\Domain\Model\CartItem>
     * @cascade remove
     */
    protected $cartitems = null;

    /**
     * client
     * 
     * @var \Bermuda\BssShop\Domain\Model\Client
     */
    protected $client = null;

    /**
     * user
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
     *
     */
    protected $user = null;

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
        $this->cartitems = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
    public function calculateTotal()
    {
        $this->total = 0;

        foreach($this-> getCartitems() as $item) {
            $this->total += $item->getTotal();
        }


    }

    /**
     * Sets the total
     * 
     * @param float $total
     * @return void
     */
//    public function setTotal($total)
//    {
//        $this->total = $total;
//    }

    /**
     * Adds a CartItem
     * 
     * @param \Bermuda\BssShop\Domain\Model\CartItem $cartitems
     * @return void
     */
    public function addCartitem(\Bermuda\BssShop\Domain\Model\CartItem $cartitems)
    {
        $this->cartitems->attach($cartitems);
    }

    /**
     * Removes a CartItem
     * 
     * @param \Bermuda\BssShop\Domain\Model\CartItem $cartitemToRemove The CartItem to be removed
     * @return void
     */
    public function removeCartitem(\Bermuda\BssShop\Domain\Model\CartItem $cartitemToRemove)
    {
        $this->cartitems->detach($cartitemToRemove);
    }

    /**
     * Returns the cartitems
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bermuda\BssShop\Domain\Model\CartItem> $cartitems
     */
    public function getCartitems()
    {
        return $this->cartitems;
    }

    /**
     * Sets the cartitems
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bermuda\BssShop\Domain\Model\CartItem> $cartitems
     * @return void
     */
    public function setCartitems(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $cartitems)
    {
        $this->cartitems = $cartitems;
    }


    /**
     * Returns one cartItem
     *
     * @return \Bermuda\BssShop\Domain\Model\CartItem $cartItem
     */
    public function getCartitemByBuild($buildId)
    {
        $query = $this->cartItemRepository->createQuery();

        $query->matching(
            $query->logicalAnd([
                $query->equals('cart',  $this->getUid()),
                $query->equals('build', $buildId),
                $query->equals('deleted', 0),
                $query->equals('hidden', 0)
            ])
        );

        $cartItems = $query->execute();

        switch (count($cartItems)) {
            case 0:
                return NULL;
            case 1:
                return $cartItems[0];
            default:
                throw new \Exception('The cartitem occurs more then once');
        }
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
     * Returns the user
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Sets the user
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $user
     * @return void
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
}
