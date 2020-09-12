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

/**
 * The repository for Products
 */

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ProductRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    // https://docs.typo3.org/m/typo3/book-extbasefluid/master/en-us/6-Persistence/3-implement-individual-database-queries.html
    public function search(
        $category = NULL,
        $search = NULL,
        $sort = NULL,
        $offset = 0,
        $limit = 9
    )
    {

            $query = $this->createQuery();

            $constraints = [];
            $constraints[] = $query->equals('deleted', 0);
            $constraints[] = $query->equals('hidden', 0);


            if ($search !== NULL) {


                $constraints[] = $query->logicalOr([
                    $query->like('name', '%' . $search . '%'),
                    $query->like('description', '%' . $search . '%')
                ]);

            }

            if ($category !== NULL) {


                $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_bssshop_domain_model_product');
                $constraintsCategory = $queryBuilder
                    ->select('tx_bssshop_domain_model_product.uid')
                    ->from('tx_bssshop_domain_model_product')
                    ->join(
                        'tx_bssshop_domain_model_product',
                        'sys_category_record_mm',
                        'sys_category_record_mm',
                        $queryBuilder->expr()->eq('sys_category_record_mm.uid_foreign', $queryBuilder->quoteIdentifier('tx_bssshop_domain_model_product.uid'))
                    )
                    ->where(
                        $queryBuilder->expr()->eq('tx_bssshop_domain_model_product.deleted', 0),
                        $queryBuilder->expr()->eq('tx_bssshop_domain_model_product.hidden', 0),
                        $queryBuilder->expr()->eq('sys_category_record_mm.uid_local', is_array($category) ? $category['uid'] : $category)
                    )->execute()->fetchAll();

                $constraints[] = $query->in('uid', $constraintsCategory);

            }

            $query->matching(
                $query->logicalAnd(
                    $constraints
                )
            );

            $orderings = [];
            if ($sort !== NULL) {

                switch ($sort) {

                    case 'price':
                        $orderings = ['builds.price' => QueryInterface::ORDER_ASCENDING];
                        break;

                    default:
                        break;
                }

            }

            $orderings['name'] = QueryInterface::ORDER_ASCENDING;

            $query->setOrderings($orderings);
            $query->setOffset($offset);
            $query->setLimit($limit);

            return $query->execute();

    }

}
