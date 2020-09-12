<?php

namespace Bermuda\BssShop\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;


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
 * AjaxController
 */
class AjaxController extends AbstractController
{

//    /**
//     * cartRepository
//     *
//     * @var \Bermuda\BssShop\Domain\Repository\CartRepository
//     * @inject
//     */
//    protected $cartRepository = null;
//
//    /**
//     * clientRepository
//     *
//     * @var \Bermuda\BssShop\Domain\Repository\ClientRepository
//     * @inject
//     */
//    protected $clientRepository = null;
//
//    /**
//     * categoryRepository
//     *
//     * @var \Bermuda\BssShop\Domain\Repository\CategoryRepository
//     * @inject
//     */
//    protected $categoryRepository;
//
//    /**
//     * The current view, as resolved by resolveView()
//     *
//     * @var ViewInterface
//     */
//    protected $view;
//
//
//    /**
//     * Prepares a view for the current action.
//     * By default, this method tries to locate a view with a name matching the current action.
//     *
//     * @return ViewInterface
//     */
//    protected function resolveView()
//    {
//        $view = $this->objectManager->get('TYPO3\CMS\Fluid\View\StandaloneView');
//        $view->setLayoutRootPaths(
//            array(GeneralUtility::getFileAbsFileName('EXT:bss_shop/Resources/Private/Layouts'))
//        );
//        $view->setPartialRootPaths(
//            array(GeneralUtility::getFileAbsFileName('EXT:bss_shop/Resources/Private/Partials'))
//        );
//        $view->setTemplateRootPaths(
//            array(GeneralUtility::getFileAbsFileName('EXT:bss_shop/Resources/Private/Templates'))
//        );
//
//
//        $this->controllerContext = $this->buildControllerContext();
//        $view->setControllerContext($this->controllerContext);
//
//
//        return $view;
//
//    }
//        /**
//     * action show
//     * @return void
//     */
//    public function showAction()
//    {
//        if(!$this->checkLogin()) return;
//
////        $view = $this->getStandaloneView();
////        $view->setTemplate('Cart/Show');
////
////        $view->assign('cart', $this->cartRepository->cart());
//
////        $view  = $this->view->assign('cart', $this->cartRepository->cart());
//        debug('Ajax Controller');
//
//        $this->view->assign('cart', $this->cartRepository->cart());
//
//    }
//
//    public function editAction()
//    {
//
//        $buildid  = isset($_POST['buildid']) ? $_POST['buildid'] : NULL;
//        $amount   = isset($_POST['amount'])  ? $_POST['amount']  : 1;
//
//        $this->cartRepository->edit($buildid, $amount);
//
////        $this->view->setTemplate('Cart/Edit');
////        $view = $this->view->assign('cart', $this->cartRepository->cart())->render();die;;
//        echo $this->view->assign('cart', $this->cartRepository->cart())->render();die;
//
//
//    }

}
