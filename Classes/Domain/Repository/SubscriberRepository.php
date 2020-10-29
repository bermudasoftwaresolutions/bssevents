<?php
namespace Bermuda\BssEvents\Domain\Repository;


class SubscriberRepository extends AbstractRepository {

    /**
     * @param $eventId
     */
    public function getAllRegisterUsersByEvent($eventId,$registrationId)
    {
        $query = $this->createQuery();

        $sql = 'SELECT subscriber. * 
                FROM tx_bssevents_domain_model_subscriber AS subscriber
                LEFT JOIN tx_bssevents_domain_model_appointment AS appointment ON subscriber.appointment = appointment.uid 
                LEFT JOIN tx_bssevents_domain_model_event AS event ON appointment.event = event.uid
                LEFT JOIN tx_bssevents_domain_model_registration AS registration ON appointment.registration = registration.uid
                WHERE event.uid = ?
                AND registration.uid = ?
                AND appointment.deleted = 0
                AND appointment.hidden = 0
                AND event.deleted = 0
                AND event.hidden = 0';
        $query->statement($sql, array($eventId,$registrationId));
        $result = $query->execute();


        return $result;
    }

}