<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Bermuda.BssShop',
            'Bssshop',
            'Shop'
        );

        $pluginSignature = str_replace('_', '', $extKey) . '_bssshop';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $extKey . '/Configuration/FlexForm/Shop.xml');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('bss_shop', 'Configuration/TypoScript', 'Bss Shop');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_bssshop_domain_model_product', 'EXT:bss_shop/Resources/Private/Language/locallang_csh_tx_bssshop_domain_model_product.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bssshop_domain_model_product');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_bssshop_domain_model_cart', 'EXT:bss_shop/Resources/Private/Language/locallang_csh_tx_bssshop_domain_model_cart.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bssshop_domain_model_cart');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_bssshop_domain_model_cartitem', 'EXT:bss_shop/Resources/Private/Language/locallang_csh_tx_bssshop_domain_model_cartitem.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bssshop_domain_model_cartitem');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_bssshop_domain_model_orderitem', 'EXT:bss_shop/Resources/Private/Language/locallang_csh_tx_bssshop_domain_model_orderitem.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bssshop_domain_model_orderitem');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_bssshop_domain_model_order', 'EXT:bss_shop/Resources/Private/Language/locallang_csh_tx_bssshop_domain_model_order.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bssshop_domain_model_order');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_bssshop_domain_model_client', 'EXT:bss_shop/Resources/Private/Language/locallang_csh_tx_bssshop_domain_model_client.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bssshop_domain_model_client');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_bssshop_domain_model_build', 'EXT:bss_shop/Resources/Private/Language/locallang_csh_tx_bssshop_domain_model_build.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bssshop_domain_model_build');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_bssshop_domain_model_orderstatus', 'EXT:bss_shop/Resources/Private/Language/locallang_csh_tx_bssshop_domain_model_build.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bssshop_domain_model_orderstatus');

    },
    $_EXTKEY
);
