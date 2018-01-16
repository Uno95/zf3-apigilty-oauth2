<?php
namespace Ticket2\V1\Service;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use Psr\Log\LoggerAwareTrait;
use Ticket2\Mapper\Ticket as TicketMapper;

class Ticket
{
    use LoggerAwareTrait;

    protected $ticketMapper;
    protected $ticketHydrator;

    public function __construct(TicketMapper $ticketMapper, DoctrineObject $ticketHydrator)
    {
        $this->setTicketMapper($ticketMapper);
        $this->setTicketHydrator($ticketHydrator);
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

    public function getTicketHydrator()
    {
        return $this->ticketHydrator;
    }

    public function setTicketHydrator(DoctrineObject $ticketHydrator)
    {
        $this->ticketHydrator = $ticketHydrator;
    }

    public function save(array $data)
    {
        $ticket = $this->getTicketHydrator()->hydrate($data, new \Ticket2\Entity\Ticket);
        $this->getTicketMapper()->save($ticket);
    }

    public function delete($id)
    {
        $ticket = $this->getTicketMapper()->fetchOneBy(['uuid' => $id]);
        $this->getTicketMapper()->delete($ticket);
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
