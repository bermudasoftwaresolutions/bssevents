<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Bermuda.BssShop',
            'Bssshop',
            [
                'Product' => 'list, show, search, selectedProductBuild, pagination',
                'Cart' => 'show, edit, update, delete, cart, checkout',
                'Order' => 'show, list, confirm, print, edit, changeOrderStatus, downloadCsv',
                'Client' => 'edit, update, create',
                'Ajax' => 'show, edit'
            ],
            // non-cacheable actions
            [
                'Product' => 'search, selectedProductBuild, pagination',
                'Cart' => 'show, edit, update, delete, cart',
                'Order' => 'show, list, confirm, print, edit, changeOrderStatus, downloadCsv',
                'Client' => 'edit, update, create',
                'Ajax' => 'show, edit'
            ]
        );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    bssshop {
                        iconIdentifier = bss_shop-plugin-bssshop
                        title = LLL:EXT:bss_shop/Resources/Private/Language/locallang_db.xlf:tx_bss_shop_bssshop.name
                        description = LLL:EXT:bss_shop/Resources/Private/Language/locallang_db.xlf:tx_bss_shop_bssshop.description
                        tt_content_defValues {
                            CType = list
                            list_type = bssshop_bssshop
                        }
                    }
                }
                show = *
            }
       }'
    );
		$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
		
			$iconRegistry->registerIcon(
				'bss_shop-plugin-bssshop',
				\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
				['source' => 'EXT:bss_shop/Resources/Public/Icons/user_plugin_bssshop.svg']
			);
		
    }
);
