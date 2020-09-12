<?php
namespace Bermuda\BssShop\Domain\Repository;


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

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class CategoryRepository extends \TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository
{
    
    private function createQueryBuilder()
    {   
        return GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('sys_category')->createQueryBuilder();
    }

    public function tree() {
        return $this->buildTree(
            $this->findUsed()
        );
    }

    private function buildTree($categorysByProduct, $parentId = 0) {
        
        $branch = array();
        foreach ($categorysByProduct as $element) {
            
            if ($element['parent'] == $parentId) {
                $children = $this->buildTree($categorysByProduct, $element['uid']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[$element['uid']] = $element;
            }
            
        }
        
        return $branch;
        
    }

    private function findUsed(){

        $query = $this->createQueryBuilder();
        
        $query = $query
            ->select('sys_category.uid', 'sys_category.title', 'sys_category.parent')
            ->from('sys_category')
            ->innerJoin(
                'sys_category',
                'sys_category_record_mm',
                'sys_category_record_mm',
                $query->expr()->eq('sys_category.uid', $query->quoteIdentifier('sys_category_record_mm.uid_local'))
            )
            ->innerJoin(
                'sys_category_record_mm',
                'tx_bssshop_domain_model_product',
                'tx_bssshop_domain_model_product',
                $query->expr()->eq('sys_category_record_mm.uid_foreign', $query->quoteIdentifier('tx_bssshop_domain_model_product.uid'))
            )
            ->where(
                $query->expr()->eq('tx_bssshop_domain_model_product.deleted',0),
                $query->expr()->eq('tx_bssshop_domain_model_product.hidden',0)
            )
            ->groupBy('sys_category.uid');
            
        $result = $query
            ->execute()
            ->fetchAll();

        return $result;
    }

    // private function findProductByCategoryId($category = NULL, $search = NULL){
    //     if(!is_null($category)) {
    //         $productsId = $this->search($search);
    //         foreach($productsId as $productId){
    //             $product[] = $this->findByUid($productId['uid']);
    //         }
    //         return $product;
    //     }
    //     if(!is_null($search)) {
    //         $product = $this->search($search);
    //         return $product;
    //     }
    // }
    
    
}