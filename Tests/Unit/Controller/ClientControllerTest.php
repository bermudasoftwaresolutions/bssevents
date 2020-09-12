<?php
namespace Bermuda\BssShop\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Bermuda Software <info@bermuda-software.ch>
 */
class ClientControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Bermuda\BssShop\Controller\ClientController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Bermuda\BssShop\Controller\ClientController::class)
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
    public function editActionAssignsTheGivenClientToView()
    {
        $client = new \Bermuda\BssShop\Domain\Model\Client();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('client', $client);

        $this->subject->editAction($client);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenClientInClientRepository()
    {
        $client = new \Bermuda\BssShop\Domain\Model\Client();

        $clientRepository = $this->getMockBuilder(\Bermuda\BssShop\Domain\Repository\ClientRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $clientRepository->expects(self::once())->method('update')->with($client);
        $this->inject($this->subject, 'clientRepository', $clientRepository);

        $this->subject->updateAction($client);
    }
}
