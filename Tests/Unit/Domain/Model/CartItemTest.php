<?php
namespace Bermuda\BssShop\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Bermuda Software <info@bermuda-software.ch>
 */
class CartItemTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Bermuda\BssShop\Domain\Model\CartItem
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Bermuda\BssShop\Domain\Model\CartItem();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getAmountReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getAmount()
        );
    }

    /**
     * @test
     */
    public function setAmountForIntSetsAmount()
    {
        $this->subject->setAmount(12);

        self::assertAttributeEquals(
            12,
            'amount',
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
    public function getProductReturnsInitialValueForProduct()
    {
        self::assertEquals(
            null,
            $this->subject->getProduct()
        );
    }

    /**
     * @test
     */
    public function setProductForProductSetsProduct()
    {
        $productFixture = new \Bermuda\BssShop\Domain\Model\Product();
        $this->subject->setProduct($productFixture);

        self::assertAttributeEquals(
            $productFixture,
            'product',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getBuildReturnsInitialValueForBuild()
    {
        self::assertEquals(
            null,
            $this->subject->getBuild()
        );
    }

    /**
     * @test
     */
    public function setBuildForBuildSetsBuild()
    {
        $buildFixture = new \Bermuda\BssShop\Domain\Model\Build();
        $this->subject->setBuild($buildFixture);

        self::assertAttributeEquals(
            $buildFixture,
            'build',
            $this->subject
        );
    }
}
