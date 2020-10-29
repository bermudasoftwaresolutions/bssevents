<?php
namespace Bermuda\BssEvents\Domain\Repository;

use Bermuda\BssEvents\Domain\Model\Appointment;
use Bermuda\BssEvents\Domain\Model\Event;

class AppointmentRepository extends AbstractRepository {

    /**
     * @param \DateTime $start
     * @param \DateTime $end
     * @param string $state
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findByMonthRange($start, $end, $state = 'disabled', $cat = 0){

        $query = $this->createQuery();

        $constraints = [];

        $constraints[] = $query->greaterThanOrEqual('date_to', $start);
        $constraints[] = $query->lessThanOrEqual('date_from', $end);
        $constraints[] = $query->logicalNot(
            $query->like('state', $state)
        );

        if($cat != 0){
            $constraints[] = $query->logicalOr(
                $query->contains('event.categories', intval($cat)),
                $query->contains('parent.event.categories', intval($cat))
            );
        }

        $query->matching($query->logicalAnd($constraints));

        $query->setOrderings(
            [
                'date_from' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
            ]
        );

        return $query->execute();

    }

    /**
     * @param int $year
     * @param int $month
     * @param int $day
     * @param string $state
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findByDateRange($year, $month, $day, $state = 'disabled', $cat = 0){

        $start = date_create_from_format('Y-m-d H:i:s', $year.'-'.$month.'-'.$day.' 00:00:00');
        $end = date_create_from_format('Y-m-d H:i:s', $year.'-'.$month.'-'.$day.' 23:59:59');

        $query = $this->createQuery();

        $constraints = [];
        $constraints[] = $query->logicalNot(
            $query->like('state', $state)
        );
        $constraints[] = $query->like('active', true);
        $constraints[] = $query->logicalOr(
            $query->like('parent', 0),
            $query->like('parent.deleted', false)
        );
        $constraints[] = $query->logicalOr(
            $query->logicalAnd(
                $query->lessThanOrEqual('date_from', $start),
                $query->greaterThanOrEqual('date_to', $start)
            ),
            $query->logicalAnd(
                $query->lessThanOrEqual('date_from', $end),
                $query->greaterThanOrEqual('date_to', $end)
            ),
            $query->logicalAnd(
                $query->greaterThanOrEqual('date_from', $start),
                $query->lessThanOrEqual('date_to', $end)
            )
        );

        if($cat != 0){
            $constraints[] = $query->logicalOr(
                $query->contains('event.categories', intval($cat)),
                $query->contains('parent.event.categories', intval($cat))
            );
        }

        $query->matching($query->logicalAnd($constraints));

        $query->setOrderings(
            [
                'date_from' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
            ]
        );

        return $query->execute();
    }

    /**
     * @param Event $event
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function getParentAppointments($event){

        //$start = date_create_from_format('Y-m-d H:i:s', $year.'-'.$month.'-'.$day.' 00:00:00');
        //$end = date_create_from_format('Y-m-d H:i:s', $year.'-'.$month.'-'.$day.' 23:59:59');

        $query = $this->createQuery();

        $query->matching(
            $query->logicalAnd(
                $query->like('parent', 0),
                $query->like('event', $event->getUid())
            )
        );

        return $query->execute();

    }

}