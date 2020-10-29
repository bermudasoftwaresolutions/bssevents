<?php
namespace Bermuda\BssEvents\Domain\Repository;

class EventRepository extends AbstractRepository {

    /**
     * @param \DateTime $date
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findByDayDate($date){

        $query = $this->createQuery();

        $query->matching(
            $query->logicalAnd(
                $query->logicalOr(
                    $query->logicalAnd(
                        $query->greaterThanOrEqual('appointments.date_to', $date->format('Y-m-d H:i:s')),
                        $query->lessThanOrEqual('appointments.date_from', $date->format('Y-m-d H:i:s'))
                    ),
                    $query->like('appointments.date_from', $date->format('Y-m-d')."%"),
                    $query->like('appointments.date_to', $date->format('Y-m-d')."%")
                )
            )
        );

        return $query->execute();
    }
}