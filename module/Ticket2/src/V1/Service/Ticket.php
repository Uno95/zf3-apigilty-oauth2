<?php
namespace Ticket2\V1\Service;

use ZF\ApiProblem\ApiProblem;
use Zend\EventManager\EventManagerAwareTrait;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use Psr\Log\LoggerAwareTrait;
use Ticket2\Mapper\Ticket as TicketMapper;
use User\Mapper\UserProfile as UserProfileMapper;
use Ticket2\V1\TicketEvent;

class Ticket
{
    use EventManagerAwareTrait;
    use LoggerAwareTrait;

    protected $ticketMapper;
    protected $userProfileMapper;
    protected $ticketHydrator;

    public function __construct(TicketMapper $ticketMapper, UserProfileMapper $userProfileMapper, DoctrineObject $ticketHydrator)
    {
        $this->setTicketMapper($ticketMapper);
        $this->setUserProfileMapper($userProfileMapper);
        $this->setTicketHydrator($ticketHydrator);
    }

    public function getTicketMapper()
    {
        return $this->ticketMapper;
    }

    public function setTicketMapper(TicketMapper $ticketMapper)
    {
        $this->ticketMapper = $ticketMapper;
    }


    public function setUserProfileMapper(UserProfileMapper $userProfileMapper)
    {
        $this->userProfileMapper = $userProfileMapper;
    }

    public function getUserProfileMapper()
    {
        return $this->userProfileMapper;
    }

    public function getTicketHydrator()
    {
        return $this->ticketHydrator;
    }

    public function setTicketHydrator(DoctrineObject $ticketHydrator)
    {
        $this->ticketHydrator = $ticketHydrator;
    }

    public function getTicketEvent()
    {
        if ($this->ticketEvent == null) {
            $this->ticketEvent = new TicketEvent();
        }

        return $this->ticketEvent;
    }

    public function setTicketEvent(TicketEvent $ticketEvent)
    {
        $this->ticketEvent = $ticketEvent;
    }

    public function save(array $data, ZendInputFilter $inputFilter)
    {

        $ticketEvent = new TicketEvent();
        $ticketEvent->setInputFilter($inputFilter);
        $ticketEvent->setName(TicketEvent::EVENT_CREATE_TICKET);
        $create = $this->getEventManager()->triggerEvent($ticketEvent);
        if ($create->stopped()) {
            $ticketEvent->setName(TicketEvent::EVENT_CREATE_TICKET_ERROR);
            $ticketEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($ticketEvent);
            throw $ticketEvent->getException();
        } else {
            $ticketEvent->setName(TicketEvent::EVENT_CREATE_TICKET_SUCCESS);
            $this->getEventManager()->triggerEvent($ticketEvent);
            return $ticketEvent->getTicketEntity();
        }
    }

    public function update($ticketObj, $inputFilter)
    {

        $ticketEvent = new TicketEvent();
        $ticketEvent->setTicketEntity($ticketObj);
        $ticketEvent->setUpdateData($inputFilter->getValues());
        $ticketEvent->setInputFilter($inputFilter);
        $ticketEvent->setName(TicketEvent::EVENT_UPDATE_TICKET);
        $update = $this->getEventManager()->triggerEvent($ticketEvent);
        if ($update->stopped()) {
            $ticketEvent->setName(TicketEvent::EVENT_UPDATE_TICKET_ERROR);
            $ticketEvent->setException($update->last());
            $this->getEventManager()->triggerEvent($ticketEvent);
            throw $ticketEvent->getException();
        } else {
            $ticketEvent->setName(TicketEvent::EVENT_UPDATE_TICKET_SUCCESS);
            $this->getEventManager()->triggerEvent($ticketEvent);
            return $ticketEvent->getTicketEntity();
        }
    }

    public function delete($id)
    {

        $ticketEvent = new TicketEvent();
        $ticketEvent->setDeletedUuid($id);
        $ticketEvent->setName(TicketEvent::EVENT_DELETE_TICKET);
        $create = $this->getEventManager()->triggerEvent($ticketEvent);
        if ($create->stopped()) {
            $ticketEvent->setName(TicketEvent::EVENT_DELETE_TICKET_ERROR);
            $ticketEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($ticketEvent);
            throw $ticketEvent->getException();
        } else {
            $ticketEvent->setName(TicketEvent::EVENT_DELETE_TICKET_SUCCESS);
            $this->getEventManager()->triggerEvent($ticketEvent);
            return true;
        }
    }
}
