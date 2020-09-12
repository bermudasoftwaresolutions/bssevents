<?php
namespace Bermuda\BssShop\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Bermuda Software <info@bermuda-software.ch>
 */
class OrderTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Bermuda\BssShop\Domain\Model\Order
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Bermuda\BssShop\Domain\Model\Order();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getNumberReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getNumber()
        );
    }

    /**
     * @test
     */
    public function setNumberForStringSetsNumber()
    {
        $this->subject->setNumber('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'number',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getMessageReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getMessage()
        );
    }

    /**
     * @test
     */
    public function setMessageForStringSetsMessage()
    {
        $this->subject->setMessage('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'message',
            $this->subject
        );
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
    public function getMerchantAddressReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getMerchantAddress()
        );
    }

    /**
     * @test
     */
    public function setMerchantAddressForStringSetsMerchantAddress()
    {
        $this->subject->setMerchantAddress('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'merchantAddress',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getClientAddressReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getClientAddress()
        );
    }

    /**
     * @test
     */
    public function setClientAddressForStringSetsClientAddress()
    {
        $this->subject->setClientAddress('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'clientAddress',
            $this->subject
        );
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

    /**
     * @test
     */
    public function getOrderitemsReturnsInitialValueForOrderItem()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getOrderitems()
        );
    }

    /**
     * @test
     */
    public function setOrderitemsForObjectStorageContainingOrderItemSetsOrderitems()
    {
        $orderitem = new \Bermuda\BssShop\Domain\Model\OrderItem();
        $objectStorageHoldingExactlyOneOrderitems = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneOrderitems->attach($orderitem);
        $this->subject->setOrderitems($objectStorageHoldingExactlyOneOrderitems);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneOrderitems,
            'orderitems',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addOrderitemToObjectStorageHoldingOrderitems()
    {
        $orderitem = new \Bermuda\BssShop\Domain\Model\OrderItem();
        $orderitemsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $orderitemsObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($orderitem));
        $this->inject($this->subject, 'orderitems', $orderitemsObjectStorageMock);

        $this->subject->addOrderitem($orderitem);
    }

    /**
     * @test
     */
    public function removeOrderitemFromObjectStorageHoldingOrderitems()
    {
        $orderitem = new \Bermuda\BssShop\Domain\Model\OrderItem();
        $orderitemsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $orderitemsObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($orderitem));
        $this->inject($this->subject, 'orderitems', $orderitemsObjectStorageMock);

        $this->subject->removeOrderitem($orderitem);
    }
}
