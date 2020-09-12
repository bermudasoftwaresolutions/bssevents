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
 * CartController
 */
class CartController extends AbstractController
{

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


//    /**
//     * action show
//     * @return void
//     */
//    public function showAction()
//    {
//        if(!$this->checkLogin()) return;
//
//        $view = $this->getStandaloneView();
//        $view->setTemplate('Cart/Show');
//
//        $view->assign('cart', $this->cartRepository->cart());
//debug('Old way');
//        echo $view->render();
//        die;
//    }

    /**
     * action show
     * @return void
     */
    public function showAction()
    {
        if(!$this->checkLogin()) return;

        echo $this->view->assign('cart', $this->cartRepository->cart())
                        ->assign('admin',  $this->userRepository->isAdmin($this->settings['merchant']['group']))
                        ->render();die;
    }

    /**
     * action edit
     * @return void
     */
    public function editAction()
    {
        if(!$this->checkLogin()) return;

        $buildid  = isset($_POST['buildid']) ? $_POST['buildid'] : NULL;
        $amount   = isset($_POST['amount'])  ? $_POST['amount']  : 1;

        $this->cartRepository->edit($buildid, $amount);

        echo $this->view->assign('cart', $this->cartRepository->cart())
                        ->assign('admin',  $this->userRepository->isAdmin($this->settings['merchant']['group']))
                        ->render();die;
    }

    /**
     * action view
     *
     * @return void
     */
    public function checkoutAction()
    {

        $this->view->assign('categories',  $this->categoryRepository->tree())
                   ->assign('cart', $this->cartRepository->cart())
                   ->assign('client', $this->clientRepository->client());


    }

    /**
     * action delete
     ** @return void
     */
    public function deleteAction()
    {
        $buildid  = isset($_POST['buildid']) ? $_POST['buildid'] : NULL;

        $this->cartRepository->removeCartItem($buildid);

        echo $this->view->assign('cart', $this->cartRepository->cart())
                        ->assign('admin',  $this->userRepository->isAdmin($this->settings['merchant']['group']))
                        ->render();die;

    }

}
