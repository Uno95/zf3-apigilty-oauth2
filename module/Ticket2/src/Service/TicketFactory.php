<?php
namespace Ticket2\V1\Service;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class FakeGpsLogFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $ticketMapper = $container->get('Ticket2\Mapper\Ticket2');
        return new Ticket($ticketMapper);

        // $ticketMapper  = $container->get(\Tiket2\Mapper\Ticket::class);
        // $fakeGpsLogService = new FakeGpsLog($fakeGpsLogMapper);
        // $fakeGpsLogService->setLogger($container->get("logger_default"));
        // return $fakeGpsLogService;
    }
}
