<?php

namespace Bermuda\BssShop\Domain\Repository;


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
 * The repository for Carts
 */
class CartRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * userRepository
     *
     * @var \Bermuda\BssShop\Domain\Repository\UserRepository
     * @inject
     */
    protected $userRepository;

    /**
     * buildRepository
     *
     * @var \Bermuda\BssShop\Domain\Repository\BuildRepository
     * @inject
     */
    protected $buildRepository;

    /**
     * @var \Bermuda\BssShop\Domain\Repository\ClientRepository
     * @inject
     */
    protected $clientRepository = null;


    public function cart()
    {

        $carts = $this->findByUser($this->userRepository->uid());

        switch (count($carts)) {
            case 0:
                $cart = new \Bermuda\BssShop\Domain\Model\Cart();
                $cart->setUser($this->userRepository->user());
                if ($this->clientRepository->findByUser($this->userRepository->uid())[0])
                    $cart->setClient($this->clientRepository->findByUser($this->userRepository->uid())[0]);
                $this->add($cart);
                $this->persistenceManager->persistAll();
                break;
            case 1:
                $cart = $carts[0];
                break;
            default:
                throw new \Exception('Too many carts');
        }

        return $cart;
    }

    public function edit($buildid, $amount)
    {

        $cart = $this->cart();
        $cartItem = $cart->getCartitemByBuild($buildid);

        if ($cartItem === NULL) {
            $cartItem = new \Bermuda\BssShop\Domain\Model\CartItem();

            $build = $this->buildRepository->findByUid($buildid);

            $cartItem->setBuild($build);
        }

        $cartItem->setAmount($amount);
        $cart->addCartitem($cartItem);
        $cart->calculateTotal();
        $this->update($cart);

        $this->persistenceManager->persistAll();
    }

    public function removeCartItem($buildid)
    {

        $cart = $this->cart();
        $cartItem = $cart->getCartitemByBuild($buildid);

        $cart->removeCartitem($cartItem);
        $cart->calculateTotal();
        $this->update($cart);

        $this->persistenceManager->persistAll();
    }

    public function addClient($client)
    {

        $cart = $this->cart();
        $cart->setClient($client);
        $this->update($cart);

        $this->persistenceManager->persistAll();
    }

}
