<?php
namespace Ticket2\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ticket2\Mapper\Ticket as TicketMapper;
use User\Mapper\UserProfile as UserProfileMapper;
use Ticket2\Entity\Ticket as TicketEntity;
use Psr\Log\LoggerAwareTrait;
use Ticket2\V1\TicketEvent;
use ZF\ApiProblem\ApiProblem;

class TicketEventListener implements ListenerAggregateInterface{

    use ListenerAggregateTrait;

    use LoggerAwareTrait;

    protected $ticketMapper;
    protected $userProfileMapper;
    protected $ticketHydrator;

    public function __construct(
        TicketMapper $ticketMapper,
        UserProfileMapper $userProfileMapper,
        DoctrineObject $ticketHydrator
    ) {
        $this->setTicketMapper($ticketMapper);
        $this->setUserProfileMapper($userProfileMapper);
        $this->setTicketHydrator($ticketHydrator);
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            TicketEvent::EVENT_CREATE_TICKET,
            [$this, 'createTicket'],
            499
        );

        $this->listeners[] = $events->attach(
            TicketEvent::EVENT_UPDATE_TICKET,
            [$this, 'updateTicket'],
            499
        );

        $this->listeners[] = $events->attach(
            TicketEvent::EVENT_DELETE_TICKET,
            [$this, 'deleteTicket'],
            499
        );
    }

    public function createTicket(TicketEvent $event)
    {
        try {
            // add file input filter here
            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $data = $event->getInputFilter()->getValues();
            $userProfileUuid    = $data['user_profile_uuid'];
            $userProfileObj     = $this->getUserProfileMapper()->getEntityRepository()->findOneBy(['uuid' => $userProfileUuid]);
            if ($userProfileObj == '') {
                return new ApiProblem(500, 'Cannot find uuid refrence');
            }

            $ticketEntity = new TicketEntity;
            $insertData = $event->getInputFilter()->getValues();
            $ticket = $this->getTicketHydrator()->hydrate($data, $ticketEntity);
            $ticket->setUserProfile($userProfileObj);
            $result = $this->getTicketMapper()->save($ticket);
            $UUID   = $result->getUuid();

            $this->logger->log(\Psr\Log\LogLevel::INFO, "{function} : New data created successfully! \nUUID: ".$UUID, ["function" => __FUNCTION__]);

            // \Zend\Debug\Debug::dump(get_class_methods($result));exit;
        } catch (\Exception $e) {
            $this->logger->log(\Psr\Log\LogLevel::ERROR, "{function} : Something Error! \nError_message: ".$e->getMessage(), ["function" => __FUNCTION__]);
        }
    }

    public function updateTicket(TicketEvent $event)
    {
        try {

            $ticketEntity = $event->getTicketEntity();
            $updateData  = $event->getUpdateData();
            $updateData = (array) $updateData;
            // add file input filter here
            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $data = $event->getInputFilter()->getValues();
            
            $userProfileUuid    = $data['user_profile_uuid'];
            $userProfileObj     = $this->getUserProfileMapper()->getEntityRepository()->findOneBy(['uuid' => $userProfileUuid]);
            if ($userProfileObj == '') {
                return new ApiProblem(500, 'Cannot find uuid refrence');
            }

            $ticket     = $this->getTicketHydrator()->hydrate($updateData, $ticketEntity);
            $ticket->setUserProfile($userProfileObj);
            $result     = $this->getTicketMapper()->save($ticket);
            $this->logger->log(\Psr\Log\LogLevel::INFO, "{function} : New data updated successfully! \nUUID: ".$UUID, ["function" => __FUNCTION__]);
        } catch (\Exception $e) {
            $this->logger->log(\Psr\Log\LogLevel::ERROR, "{function} : Something Error! \nError_message: ".$e->getMessage(), ["function" => __FUNCTION__]);
        }
    }

    public function deleteTicket(TicketEvent $event)
    {
        try{
            $deletedUuid  = $event->getDeletedUuid();
            $ticketObj  = $this->getTicketMapper()->getEntityRepository()->findOneBy(['uuid' => $deletedUuid]);
            // \Zend\Debug\Debug::dump($ticketObj);exit;
            $this->getTicketMapper()->delete($ticketObj);
            $this->logger->log(\Psr\Log\LogLevel::INFO, "{function} : New data deleted successfully!", ["function" => __FUNCTION__]);
            return true;
        }catch(\Exception $e){
            $this->logger->log(\Psr\Log\LogLevel::ERROR, "{function} : Something Error! \nError_message: ".$e->getMessage(), ["function" => __FUNCTION__]);
        }
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

    public function setTicketHydrator($ticketHydrator)
    {
        $this->ticketHydrator = $ticketHydrator;
    }

}