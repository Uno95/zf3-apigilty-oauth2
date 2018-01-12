<?php
return [
    'service_manager' => [
        'factories' => [
            \Ticket2\V1\Rest\ShowTickets\ShowTicketsResource::class => \Ticket2\V1\Rest\ShowTickets\ShowTicketsResourceFactory::class,
        ],
        'abstract_factories' => [
            0 => \Ticket2\Mapper\AbstractMapperFactory::class,
        ],
    ],
    'hydrators' => [
        'factories' => [
            'Ticket2\\Hydrator\\Ticket' => \Ticket2\V1\Hydrator\TicketHydratorFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'ticket2.rest.show-tickets' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/ticket[/:uuid]',
                    'defaults' => [
                        'controller' => 'Ticket2\\V1\\Rest\\ShowTickets\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'ticket2.rest.show-tickets',
        ],
    ],
    'zf-rest' => [
        'Ticket2\\V1\\Rest\\ShowTickets\\Controller' => [
            'listener' => \Ticket2\V1\Rest\ShowTickets\ShowTicketsResource::class,
            'route_name' => 'ticket2.rest.show-tickets',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'ticket',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_http_methods' => [
                0 => 'GET',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Ticket2\Entity\Ticket::class,
            'collection_class' => \Ticket2\V1\Rest\ShowTickets\ShowTicketsCollection::class,
            'service_name' => 'Ticket',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'Ticket2\\V1\\Rest\\ShowTickets\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'Ticket2\\V1\\Rest\\ShowTickets\\Controller' => [
                0 => 'application/hal+json',
                1 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'Ticket2\\V1\\Rest\\ShowTickets\\Controller' => [
                0 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \Ticket2\Entity\Ticket::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'ticket2.rest.show-tickets',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'Ticket2\\Hydrator\\Ticket',
            ],
            \Ticket2\V1\Rest\ShowTickets\ShowTicketsCollection::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'ticket2.rest.show-tickets',
                'route_identifier_name' => 'uuid',
                'is_collection' => true,
            ],
        ],
    ],
    'zf-mvc-auth' => [
        'authorization' => [
            'Ticket2\\V1\\Rest\\ShowTickets\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
            ],
        ],
    ],
];
