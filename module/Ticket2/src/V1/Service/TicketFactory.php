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
        return new Ticket($ticketMapper, $ticketHydrator);

        // $ticketMapper  = $container->get(\Tiket2\Mapper\Ticket::class);
        // $fakeGpsLogService = new FakeGpsLog($fakeGpsLogMapper);
        // $fakeGpsLogService->setLogger($container->get("logger_default"));
        // return $fakeGpsLogService;
    }
}
