<?php
namespace Bermuda\BssShop\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Bermuda Software <info@bermuda-software.ch>
 */
class ProductTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Bermuda\BssShop\Domain\Model\Product
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Bermuda\BssShop\Domain\Model\Product();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getNameReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getName()
        );
    }

    /**
     * @test
     */
    public function setNameForStringSetsName()
    {
        $this->subject->setName('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'name',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDescriptionReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getDescription()
        );
    }

    /**
     * @test
     */
    public function setDescriptionForStringSetsDescription()
    {
        $this->subject->setDescription('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'description',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getBuildsReturnsInitialValueForBuild()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getBuilds()
        );
    }

    /**
     * @test
     */
    public function setBuildsForObjectStorageContainingBuildSetsBuilds()
    {
        $build = new \Bermuda\BssShop\Domain\Model\Build();
        $objectStorageHoldingExactlyOneBuilds = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneBuilds->attach($build);
        $this->subject->setBuilds($objectStorageHoldingExactlyOneBuilds);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneBuilds,
            'builds',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addBuildToObjectStorageHoldingBuilds()
    {
        $build = new \Bermuda\BssShop\Domain\Model\Build();
        $buildsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $buildsObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($build));
        $this->inject($this->subject, 'builds', $buildsObjectStorageMock);

        $this->subject->addBuild($build);
    }

    /**
     * @test
     */
    public function removeBuildFromObjectStorageHoldingBuilds()
    {
        $build = new \Bermuda\BssShop\Domain\Model\Build();
        $buildsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $buildsObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($build));
        $this->inject($this->subject, 'builds', $buildsObjectStorageMock);

        $this->subject->removeBuild($build);
    }

    /**
     * @test
     */
    public function getCategoryReturnsInitialValueForCategory()
    {
    }

    /**
     * @test
     */
    public function setCategoryForCategorySetsCategory()
    {
    }
}
