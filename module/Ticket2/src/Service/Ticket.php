<?php
namespace Ticket2\V1\Service;

use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use Psr\Log\LoggerAwareTrait;
use User\Mapper\Ticket as TicketMapper;

class FakeGpsLog
{
    use LoggerAwareTrait;

    protected $ticketMapper;

    public function __construct(TicketMapper $ticketMapper)
    {
        $this->setTicketMapper($ticketMapper);
    }


    public function getTicketMapper()
    {
        return $this->ticketMapper;
    }

    /**
     * @param UserProfileMapper $userProfileMapper
     */
    public function setTicketMapper(TicketMapper $ticketMapper)
    {
        $this->ticketMapper = $ticketMapper;
    }

    // /**
    //  * Retrieve customer by account
    //  *
    //  * @param  \User\Entity\Customer $ticket
    //  * @return array
    //  */
    // public function fetchByAccount(\User\Entity\Account $account)
    // {
    //     return $this->getFakeGpsLogMapper()
    //                 ->getEntityRepository()
    //                 ->findBy(['account' => $account], ['createdAt' => 'DESC']);
    // }

    // /**
    //  * Create FakeGpsLog
    //  *
    //  * @param array $ticketData
    //  * @param \Zend\InputFilter\InputFilter $inputFilter
    //  */
    // public function create(array $data, ZendInputFilter $inputFilter)
    // {
    //     if (isset($data['userProfile'])) {
    //         $inputFilter->add(['name'  => 'userProfile']);
    //         $inputFilter->get('userProfile')->setValue($data['userProfile']);
    //     }

    //     if (isset($data['ticket'])) {
    //         $inputFilter->add(['name'  => 'ticket']);
    //         $inputFilter->get('ticket')->setValue($data['ticket']);
    //     }

    //     if (isset($data['account'])) {
    //         $inputFilter->add(['name'  => 'account']);
    //         $inputFilter->get('account')->setValue($data['account']);
    //     }

    //     $fakeGpsLogEvent = $this->getFakeGpsLogEvent();
    //     $fakeGpsLogEvent->setInputFilter($inputFilter);
    //     $fakeGpsLogEvent->setName(FakeGpsLogEvent::EVENT_CREATE_FAKE_GPS_LOG);
    //     $create = $this->getEventManager()->triggerEvent($fakeGpsLogEvent);
    //     if ($create->stopped()) {
    //         $fakeGpsLogEvent->setName(FakeGpsLogEvent::EVENT_CREATE_FAKE_GPS_LOG_ERROR);
    //         $fakeGpsLogEvent->setException($create->last());
    //         // trigger FakeGpsLogEvent::EVENT_CREATE_FAKE_GPS_LOG_ERROR
    //         $this->getEventManager()->triggerEvent($fakeGpsLogEvent);
    //         throw $fakeGpsLogEvent->getException();
    //     } else {
    //         // trigger FakeGpsLogEvent::EVENT_CREATE_FAKE_GPS_LOG_SUCCESS
    //         $fakeGpsLogEvent->setName(FakeGpsLogEvent::EVENT_CREATE_FAKE_GPS_LOG_SUCCESS);
    //         $this->getEventManager()->triggerEvent($fakeGpsLogEvent);
    //         return $fakeGpsLogEvent->getFakeGpsLogEntity();
    //     }
    // }
}
