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
 * Product
 */
class Product extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * name
     * 
     * @var string
     * @validate NotEmpty
     */
    protected $name = '';

    /**
     * description
     * 
     * @var string
     */
    protected $description = '';

    /**
     * builds
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bermuda\BssShop\Domain\Model\Build>
     * @cascade remove
     */
    protected $builds = null;

    /**
     * category
     * 
     * @var \TYPO3\CMS\Extbase\Domain\Model\Category
     */
    protected $category = null;

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
        $this->builds = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the name
     * 
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     * 
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the description
     * 
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     * 
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Adds a Build
     * 
     * @param \Bermuda\BssShop\Domain\Model\Build $build
     * @return void
     */
    public function addBuild(\Bermuda\BssShop\Domain\Model\Build $build)
    {
        $this->builds->attach($build);
    }

    /**
     * Removes a Build
     * 
     * @param \Bermuda\BssShop\Domain\Model\Build $buildToRemove The Build to be removed
     * @return void
     */
    public function removeBuild(\Bermuda\BssShop\Domain\Model\Build $buildToRemove)
    {
        $this->builds->detach($buildToRemove);
    }

    /**
     * Returns the builds
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bermuda\BssShop\Domain\Model\Build> $builds
     */
    public function getBuilds()
    {
        return $this->builds;
    }

    /**
     * Sets the builds
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bermuda\BssShop\Domain\Model\Build> $builds
     * @return void
     */
    public function setBuilds(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $builds)
    {
        $this->builds = $builds;
    }

    /**
     * Returns the category
     * 
     * @return \TYPO3\CMS\Extbase\Domain\Model\Category $category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Sets the category
     * 
     * @param \TYPO3\CMS\Extbase\Domain\Model\Category $category
     * @return void
     */
    public function setCategory(\TYPO3\CMS\Extbase\Domain\Model\Category $category)
    {
        $this->category = $category;
    }
}
