<?php
namespace Ticket2;

use ZF\Apigility\Provider\ApigilityProviderInterface;

class Module implements ApigilityProviderInterface
{

    public function getConfig()
    {
        $config = [];
        $configFiles = [
            __DIR__ . '/config/module.config.php',
            __DIR__ . '/config/doctrine.config.php',  // configuration for doctrine
        ];

        // merge all module config options
        foreach ($configFiles as $configFile) {
            $config = \Zend\Stdlib\ArrayUtils::merge($config, include $configFile, true);
        }

        return $config;
    }

    public function getAutoloaderConfig()
    {
        return [
            'ZF\Apigility\Autoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src',
                ],
            ],
        ];
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                'ticket.showTickets' => function ($sm) {
                    $adapter = $sm->get('zf3_mysql');
                    return new \Ticket2\V1\Rest\ShowTickets\ShowTicketsMapper($adapter);
                },
            ],
        ];
    }
}
