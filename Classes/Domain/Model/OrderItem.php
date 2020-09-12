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
 * OrderItem
 */
class OrderItem extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * productName
     * 
     * @var string
     */
    protected $productName = '';

    /**
     * buildName
     * 
     * @var string
     */
    protected $buildName = '';

    /**
     * code
     * 
     * @var string
     */
    protected $code = '';

    /**
     * amount
     * 
     * @var int
     */
    protected $amount = 0;

    /**
     * price
     * 
     * @var float
     */
    protected $price = 0.0;

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
     * Returns the productName
     * 
     * @return string $productName
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * Sets the productName
     * 
     * @param string $productName
     * @return void
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;
    }

    /**
     * Returns the buildName
     * 
     * @return string $buildName
     */
    public function getBuildName()
    {
        return $this->buildName;
    }

    /**
     * Sets the buildName
     * 
     * @param string $buildName
     * @return void
     */
    public function setBuildName($buildName)
    {
        $this->buildName = $buildName;
    }

    /**
     * Returns the code
     * 
     * @return string $code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Sets the code
     * 
     * @param string $code
     * @return void
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

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
    }

    /**
     * Returns the price
     * 
     * @return float $price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Sets the price
     * 
     * @param float $price
     * @return void
     */
    public function setPrice($price)
    {
        $this->price = $price;
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
    }
}
