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
        $result = $this->getTicketMapper()->save($ticket);
        if(!$result)
            $this->logger->log(\Psr\Log\LogLevel::ERROR, "{function} : Cannot create new data!", ["function" => __FUNCTION__]);
        else    
            $this->logger->log(\Psr\Log\LogLevel::INFO, "{function} : New data created successfully!", ["function" => __FUNCTION__]);
    }

    public function update($id, $data)
    {
        $ticketObj  = $this->getTicketMapper()->getEntityRepository()->findOneBy(['uuid' => $id]);
        $ticket     = $this->getTicketHydrator()->hydrate($data, $ticketObj);
        $this->getTicketMapper()->save($ticket);
        $this->logger->log(\Psr\Log\LogLevel::INFO, "{function} : New data updated successfully!", ["function" => __FUNCTION__]);
    }

    public function delete($id)
    {
        $ticket = $this->getTicketMapper()->getEntityRepository()->findOneBy(['uuid' => $id]);
        $this->getTicketMapper()->delete($ticket);
        $this->logger->log(\Psr\Log\LogLevel::INFO, "{function} : New data deleted successfully!", ["function" => __FUNCTION__]);
        return true;
    }
}
