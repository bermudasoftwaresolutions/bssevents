<?php
namespace Bermuda\BssShop\Controller;


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
 * OrderController
 */
class OrderController extends AbstractController
{

    /**
     * orderRepository
     * 
     * @var \Bermuda\BssShop\Domain\Repository\OrderRepository
     * @inject
     */
    protected $orderRepository = null;

    /**
     * cartRepository
     *
     * @var \Bermuda\BssShop\Domain\Repository\CartRepository
     * @inject
     */
    protected $cartRepository = null;

    /**
     * clientRepository
     *
     * @var \Bermuda\BssShop\Domain\Repository\ClientRepository
     * @inject
     */
    protected $clientRepository = null;

    /**
     * categoryRepository
     *
     * @var \Bermuda\BssShop\Domain\Repository\CategoryRepository
     * @inject
     */
    protected $categoryRepository;

    /**
     * orderStatusRepository
     *
     * @var \Bermuda\BssShop\Domain\Repository\OrderStatusRepository
     * @inject
     */
    protected $orderStatusRepository = null;

    /**
     * action confirm
     *
     * @return void
     */
    public function confirmAction()
    {

        $args = $this->request->getArguments();

        $order = $this->orderRepository->order($this->cartRepository->cart(), $args, true);

        $recipient     = $this->clientRepository->client()->getEmail()   ?
                         $this->clientRepository->client()->getEmail()   : 'kapormarko377@yahoo.com';


        $this->sendEmail('Emails/ConfirmationEmail',
                                  $recipient,
                          'Confirmation Mail',
                                  $order);

        $this->sendEmail('Emails/ConfirmationEmail',
                                  $this->settings['merchant']['email'],
                          'Confirmation Mail Admin',
                                  $order);

        $this->view->assign('categories',  $this->categoryRepository->tree())
                   ->assign('order', $order)
                   ->assign('client', $this->clientRepository->client());

    }

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {

        $this->view->assign('categories',  $this->categoryRepository->tree())
                    ->assign('orders', $this->orderRepository->findByClient($this->clientRepository->client()->getUid()))
                    ->assign('client', $this->clientRepository->client());

    }

    /**
     * action show
     *
     * @return void
     */
    public function showAction()
    {

        $args = $this->request->getArguments();

        $this->view->assign('categories',  $this->categoryRepository->tree())
                    ->assign('order', $this->orderRepository->findByUid($args['orderUid']))
                    ->assign('client', $this->clientRepository->client());

    }

    /**
     * action print
     *
     * @return void
     */
    public function printAction()
    {

        $args = $this->request->getArguments();

        $this->view->assign('categories',  $this->categoryRepository->tree())
            ->assign('order', $this->orderRepository->findByUid($args['orderUid']))
            ->assign('client', $this->clientRepository->client());

    }

    /**
     * action edit
     *
     * @return void
     */
    public function editAction()
    {

        $args = $this->request->getArguments();
        $search     = isset($args['search'])   ? $args['search']   : NULL;
        $sort       = isset($args['sort'])     ? $args['sort']     : NULL;
//        $offset     = isset($args['offset'])   ? $args['offset']   : 0;
//        $limit      = isset($args['limit'])    ? $args['limit']    : 9;

        $this->view->assign('categories',  $this->categoryRepository->tree())
            ->assign('orders', $this->orderRepository->search($search, $sort))
            ->assign('search', $search)
            ->assign('sort', $sort)
            ->assign('defaultStatus', $this->orderStatusRepository->findByUid(1))
            ->assign('statuses', $this->orderStatusRepository->findAll())
            ->assign('client', $this->clientRepository->client());

    }

    /**
     * action changeOrderStatus
     *
     * @return void
     */
    public function changeOrderStatusAction()
    {

        echo $this->view->assign('order', $this->orderRepository->orderStatus($_POST['orderUid'], $_POST['statusUid']))
                        ->assign('defaultStatus', $this->orderStatusRepository->findByUid(1))
                        ->assign('statuses', $this->orderStatusRepository->findAll())
                        ->render();die;

    }

    /**
     * action downloadCsv
     *
     * @return void
     */
    public function downloadCsvAction()
    {

        $args = $this->request->getArguments();
        $search     = isset($args['search'])   ? $args['search']   : NULL;
        $sort       = isset($args['sort'])     ? $args['sort']     : NULL;

        $this->orderRepository->search($search, $sort, TRUE);


    }


}
