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
        // $ticketEvent->setUpdateData($inputFilter->getValues());
        // \Zend\Debug\Debug::dump($inputFilter->getValues());exit;
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

    public function update($id, $data)
    {

        $ticketEvent = new TicketEvent();
        $ticketEvent->setInputFilter($inputFilter);
        $ticketEvent->setName(TicketEvent::EVENT_UPDATE_TICKET);
        $create = $this->getEventManager()->triggerEvent($ticketEvent);
        if ($create->stopped()) {
            $ticketEvent->setName(TicketEvent::EVENT_UPDATE_TICKET_ERROR);
            $ticketEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($ticketEvent);
            throw $ticketEvent->getException();
        } else {
            $ticketEvent->setName(TicketEvent::EVENT_UPDATE_TICKET_SUCCES);
            $this->getEventManager()->triggerEvent($ticketEvent);
            return $ticketEvent->getTicketEntity();
        }
        
        try {
            $userProfileUuid    = $data['user_profile_uuid'];
            $userProfileObj     = $this->getUserProfileMapper()->getEntityRepository()->findOneBy(['uuid' => $userProfileUuid]);
            if ($userProfileObj == '') {
                return new ApiProblem(500, 'Cannot find uuid refrence');
            }

            $ticketObj  = $this->getTicketMapper()->getEntityRepository()->findOneBy(['uuid' => $id]);
            $ticket     = $this->getTicketHydrator()->hydrate($data, $ticketObj);
            $ticket->setUserProfile($userProfileObj);
            $result     = $this->getTicketMapper()->save($ticket);
            $this->logger->log(\Psr\Log\LogLevel::INFO, "{function} : New data updated successfully! \nUUID: ".$UUID, ["function" => __FUNCTION__]);
        } catch (\Exception $e) {
            $this->logger->log(\Psr\Log\LogLevel::ERROR, "{function} : Something Error! \nError_message: ".$e->getMessage(), ["function" => __FUNCTION__]);
        }
    }

    public function delete($id)
    {
        try {
            $ticket = $this->getTicketMapper()->getEntityRepository()->findOneBy(['uuid' => $id]);
            $this->getTicketMapper()->delete($ticket);
            $this->logger->log(\Psr\Log\LogLevel::INFO, "{function} : New data deleted successfully!", ["function" => __FUNCTION__]);
            return true;
        } catch (\Exception $e) {
            $this->logger->log(\Psr\Log\LogLevel::ERROR, "{function} : Something Error! \nError_message: ".$e->getMessage(), ["function" => __FUNCTION__]);
        }
    }
}
