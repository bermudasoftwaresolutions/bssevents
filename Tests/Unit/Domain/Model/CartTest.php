<?php
namespace Bermuda\BssShop\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Bermuda Software <info@bermuda-software.ch>
 */
class CartTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Bermuda\BssShop\Domain\Model\Cart
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Bermuda\BssShop\Domain\Model\Cart();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getTotalReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getTotal()
        );
    }

    /**
     * @test
     */
    public function setTotalForFloatSetsTotal()
    {
        $this->subject->setTotal(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'total',
            $this->subject,
            '',
            0.000000001
        );
    }

    /**
     * @test
     */
    public function getCatitemsReturnsInitialValueForCartItem()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getCatitems()
        );
    }

    /**
     * @test
     */
    public function setCatitemsForObjectStorageContainingCartItemSetsCatitems()
    {
        $catitem = new \Bermuda\BssShop\Domain\Model\CartItem();
        $objectStorageHoldingExactlyOneCatitems = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneCatitems->attach($catitem);
        $this->subject->setCatitems($objectStorageHoldingExactlyOneCatitems);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneCatitems,
            'catitems',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addCatitemToObjectStorageHoldingCatitems()
    {
        $catitem = new \Bermuda\BssShop\Domain\Model\CartItem();
        $catitemsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $catitemsObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($catitem));
        $this->inject($this->subject, 'catitems', $catitemsObjectStorageMock);

        $this->subject->addCatitem($catitem);
    }

    /**
     * @test
     */
    public function removeCatitemFromObjectStorageHoldingCatitems()
    {
        $catitem = new \Bermuda\BssShop\Domain\Model\CartItem();
        $catitemsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $catitemsObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($catitem));
        $this->inject($this->subject, 'catitems', $catitemsObjectStorageMock);

        $this->subject->removeCatitem($catitem);
    }

    /**
     * @test
     */
    public function getClientReturnsInitialValueForClient()
    {
        self::assertEquals(
            null,
            $this->subject->getClient()
        );
    }

    /**
     * @test
     */
    public function setClientForClientSetsClient()
    {
        $clientFixture = new \Bermuda\BssShop\Domain\Model\Client();
        $this->subject->setClient($clientFixture);

        self::assertAttributeEquals(
            $clientFixture,
            'client',
            $this->subject
        );
    }
}
