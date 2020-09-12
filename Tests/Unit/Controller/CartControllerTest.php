<?php
namespace Bermuda\BssShop\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Bermuda Software <info@bermuda-software.ch>
 */
class CartControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Bermuda\BssShop\Controller\CartController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Bermuda\BssShop\Controller\CartController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenCartToView()
    {
        $cart = new \Bermuda\BssShop\Domain\Model\Cart();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('cart', $cart);

        $this->subject->editAction($cart);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenCartInCartRepository()
    {
        $cart = new \Bermuda\BssShop\Domain\Model\Cart();

        $cartRepository = $this->getMockBuilder(\Bermuda\BssShop\Domain\Repository\CartRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $cartRepository->expects(self::once())->method('update')->with($cart);
        $this->inject($this->subject, 'cartRepository', $cartRepository);

        $this->subject->updateAction($cart);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenCartFromCartRepository()
    {
        $cart = new \Bermuda\BssShop\Domain\Model\Cart();

        $cartRepository = $this->getMockBuilder(\Bermuda\BssShop\Domain\Repository\CartRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $cartRepository->expects(self::once())->method('remove')->with($cart);
        $this->inject($this->subject, 'cartRepository', $cartRepository);

        $this->subject->deleteAction($cart);
    }
}
