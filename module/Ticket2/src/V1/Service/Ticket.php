<?php
namespace Ticket2\V1\Service;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use Psr\Log\LoggerAwareTrait;
use Ticket2\Mapper\Ticket as TicketMapper;
use User\Mapper\UserProfile as UserProfileMapper;

class Ticket
{
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

    public function getTicketHydrator()
    {
        return $this->ticketHydrator;
    }

    public function getUserProfileMapper()
    {
        return $this->userProfileMapper;
    }

    public function setTicketHydrator(DoctrineObject $ticketHydrator)
    {
        $this->ticketHydrator = $ticketHydrator;
    }

    public function save(array $data)
    {
        try {
            $userProfileUuid    = $data['user_profile_uuid'];
            $userProfileObj     = $this->getUserProfileMapper()->getEntityRepository()->findOneBy(['uuid' => $userProfileUuid]);
            // var_dump($userProfileUuid);
            // exit;
            $ticket = $this->getTicketHydrator()->hydrate($data, new \Ticket2\Entity\Ticket);
            $ticket->setUserProfile($userProfileObj);
            $result = $this->getTicketMapper()->save($ticket);
            $UUID   = $result->getUuid();

            $this->logger->log(\Psr\Log\LogLevel::INFO, "{function} : New data created successfully! \nUUID: ".$UUID, ["function" => __FUNCTION__]);

            // \Zend\Debug\Debug::dump(get_class_methods($result));exit;
        } catch (\Exception $e) {
            $this->logger->log(\Psr\Log\LogLevel::ERROR, "{function} : Something Error! \nError_message: ".$e->getMessage(), ["function" => __FUNCTION__]);
        }
    }

    public function update($id, $data)
    {
        try {
            $ticketObj  = $this->getTicketMapper()->getEntityRepository()->findOneBy(['uuid' => $id]);
            $ticket     = $this->getTicketHydrator()->hydrate($data, $ticketObj);
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
