<?php

namespace Bermuda\BssShop\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;


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
 * The repository for Orders
 */
class OrderRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * cartRepository
     *
     * @var \Bermuda\BssShop\Domain\Repository\CartRepository
     * @inject
     */
    protected $cartRepository = null;

    /**
     * OrderStatusRepository
     *
     * @var \Bermuda\BssShop\Domain\Repository\OrderStatusRepository
     * @inject
     */
    protected $orderStatusRepository = null;

    public function order($cart, $args, $deleteCart = null)
    {

        $order = new \Bermuda\BssShop\Domain\Model\Order();
        $order->setMessage($args['form']['message']);
        $order->setTotal($cart->getTotal());
        $order->setOrderStatus($this->orderStatusRepository->findByUid(1));
        $order->setStatus($this->orderStatusRepository->findByUid(1)->getStatus());
        $order->setMerchantAddress($args['settings']['merchant']['street']);
        $order->setClientAddress($args['form']['street']);
        $order->setClient($cart->getClient());

        $this->add($order);

        foreach ($cart->getCartitems() as $item) {

            $orderItem = new \Bermuda\BssShop\Domain\Model\OrderItem();
            $orderItem->setProductName($item->getBuild()->getProduct()->getName());
            $orderItem->setBuildName($item->getBuild()->getName());
            $orderItem->setCode($item->getBuild()->getCode());
            $orderItem->setAmount($item->getAmount());
            $orderItem->setPrice($item->getBuild()->getPrice());
            $orderItem->setTotal($item->getTotal());
            $orderItem->setProduct($item->getBuild()->getProduct());
            $orderItem->setBuild($item->getBuild());
            $order->addOrderitem($orderItem);

        }
        $this->persistenceManager->persistAll();

        $this->update($order);

        if ($deleteCart){
            $this->cartRepository->remove($cart);
        }

        return $order;


    }

    public function search(
        $search = NULL,
        $sort = NULL,
        $csvExport = NULL
//        $offset = 0,
//        $limit = 9
    )
    {

        $query = $this->createQuery();

        $constraints = [];
        $constraints[] = $query->equals('deleted', 0);


        if ($search !== NULL) {

            $constraints[] = $query->logicalOr([
                $query->like('uid', '%' . $search . '%'),
                $query->like('status', '%' . $search . '%'),
                $query->like('client.name', '%' . $search . '%'),
                $query->like('tstamp', '%' . $search . '%'),
                $query->like('total', '%' . $search . '%')
            ]);

        }

        $query->matching(
            $query->logicalAnd(
                $constraints
            )
        );

        $orderings = [];
        if ($sort !== NULL) {

            switch ($sort) {

                case 'status':
                    $orderings = ['status' => QueryInterface::ORDER_ASCENDING];
                    break;
                case 'total':
                    $orderings = ['total' => QueryInterface::ORDER_ASCENDING];
                    break;
                case 'client':
                    $orderings = ['client.name' => QueryInterface::ORDER_ASCENDING];
                    break;

                default:
                    break;
            }

        }

        $orderings['crdate'] = QueryInterface::ORDER_ASCENDING;

        $query->setOrderings($orderings);
//        $query->setOffset($offset);
//        $query->setLimit($limit);

        if ($csvExport !== NULL) {

            $this->csvExport($query->execute());

        }

        return $query->execute();

    }


    public function csvExport($rows)
    {

        $header = array('Order No.', 'Status', 'Date', 'Client', 'Total');

        $fp = fopen('php://output', 'w');

        fputcsv($fp, $header);

        foreach ($rows as $row) {

            $row = ['uid' => $row->getUid(),
                    'status' => $row->getStatus(),
                    'crdate' => substr(((array)$row->getCrdate())['date'], 0, 10),
                    'client' => $row->getClient()->getName(),
                    'total' => $row->getTotal()];

            header("Content-Type: text/csv");
            header("Content-Disposition: attachment; filename=orders.csv");
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Pragma: no-cache");
            header("Expires: 0");

            fputcsv($fp, $row);
        }
        fclose($fp);
        die();

    }


    public function orderStatus($orderId, $status)
    {
        $order = $this->findByUid($orderId);
        $order->setOrderStatus($this->orderStatusRepository->findByUid($status));
        $order->setStatus($this->orderStatusRepository->findByUid($status)->getStatus());

        $this->update($order);
        $this->persistenceManager->persistAll();

        return $order;

    }

}
