<?php
namespace Ticket2\V1\Service;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

class TicketFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $ticketMapper = $container->get('Ticket2\Mapper\Ticket');
        $ticketHydrator = $container->get('HydratorManager')->get('Ticket2\\Hydrator\\Ticket');
        $userProfileMapper = $container->get('User\Mapper\UserProfile');
        $ticket = new Ticket($ticketMapper, $userProfileMapper, $ticketHydrator);
        $ticket->setLogger($container->get("logger_default"));
        return $ticket;
    }
}
