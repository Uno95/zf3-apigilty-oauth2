<?php
namespace Ticket2\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class TicketEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $ticketMapper    = $container->get('Ticket2\Mapper\Ticket');
        $userProfileMapper = $container->get('User\Mapper\UserProfile');
        $ticketHydrator  = $container->get('HydratorManager')->get('Ticket2\Hydrator\Ticket');
        $ticketEventListener = new TicketEventListener($ticketMapper, $userProfileMapper, $ticketHydrator);
        $ticketEventListener->setLogger($container->get("logger_default"));
        return $ticketEventListener;
    }
}
