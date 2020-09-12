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
 * AbstractController
 */

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Core\Utility\GeneralUtility;

abstract class AbstractController extends ActionController
{
    /**
     * @var \Bermuda\BssShop\Domain\Repository\UserRepository
     * @inject
     */
    protected $userRepository;


    public function checkLogin()
    {
        if ($this->userRepository->isUser()) {
            return TRUE;
        }

        $this->redirectToUri(
            $this->uriBuilder
                ->setTargetPageUid($this->settings['merchant']['login'])
                ->build()
        );

        return FALSE;
    }

    

    /**
     * @return StandaloneView
     */
    public function getStandaloneView()
    {
        $standaloneView = $this->objectManager->get('TYPO3\CMS\Fluid\View\StandaloneView');
        $standaloneView->setLayoutRootPaths(
            array(GeneralUtility::getFileAbsFileName('EXT:bss_shop/Resources/Private/Layouts'))
        );
        $standaloneView->setPartialRootPaths(
            array(GeneralUtility::getFileAbsFileName('EXT:bss_shop/Resources/Private/Partials'))
        );
        $standaloneView->setTemplateRootPaths(
            array(GeneralUtility::getFileAbsFileName('EXT:bss_shop/Resources/Private/Templates'))
        );

        $standaloneView->getRequest()->setControllerExtensionName('bssshop');
        $standaloneView->getRequest()->setPluginName('bssshop');

        return $standaloneView;
    }



    public function sendEmail($template, $receiver, $subject, $order){

        $email = $this->getStandaloneView();
        $email->setTemplate($template);

        $email->assign('order', $order)
              ->assign('baseUrl', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]");

        $emailBody = $email->render();

        $message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Mail\\MailMessage');
        $message->setTo($receiver)
                ->setSubject($subject);

        $message->setBody($emailBody, 'text/html');

        $message->send();
    }


}
