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
 * CartItem
 */
class CartItem extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * amount
     * 
     * @var int
     */
    protected $amount = 0;

    /**
     * total
     * 
     * @var float
     */
    protected $total = 0.0;

    /**
     * product
     * 
     * @var \Bermuda\BssShop\Domain\Model\Product
     */
    protected $product = null;

    /**
     * build
     * 
     * @var \Bermuda\BssShop\Domain\Model\Build
     */
    protected $build = null;

    /**
     * Returns the amount
     * 
     * @return int $amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Sets the amount
     * 
     * @param int $amount
     * @return void
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        $this->total = $amount * $this->getBuild()->getPrice();

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
//    public function setTotal($total)
//    {
//        $this->total = $total;
//    }

    /**
     * Returns the product
     * 
     * @return \Bermuda\BssShop\Domain\Model\Product $product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Sets the product
     *
     * @param \Bermuda\BssShop\Domain\Model\Product $product
     * @return void
     */
    public function setProduct(\Bermuda\BssShop\Domain\Model\Product $product)
    {
        $this->product = $product;
    }

    /**
     * Returns the build
     * 
     * @return \Bermuda\BssShop\Domain\Model\Build $build
     */
    public function getBuild()
    {
        return $this->build;
    }

    /**
     * Sets the build
     * 
     * @param \Bermuda\BssShop\Domain\Model\Build $build
     * @return void
     */
    public function setBuild(\Bermuda\BssShop\Domain\Model\Build $build)
    {
        $this->build = $build;

//        debug($build->getProduct());
//
        $this->setProduct($build->getProduct());
    }
}
