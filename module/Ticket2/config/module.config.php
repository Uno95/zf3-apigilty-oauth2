<?php
return [
    'service_manager' => [
        'factories' => [
            \Ticket2\V1\Rest\ShowTickets\ShowTicketsResource::class => \Ticket2\V1\Rest\ShowTickets\ShowTicketsResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'ticket2.rest.show-tickets' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/ticket',
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
            'route_identifier_name' => 'show_tickets_id',
            'collection_name' => 'show_tickets',
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
            'entity_class' => \Ticket2\V1\Rest\ShowTickets\ShowTicketsEntity::class,
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
            \Ticket2\V1\Rest\ShowTickets\ShowTicketsEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'ticket2.rest.show-tickets',
                'route_identifier_name' => 'show_tickets_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \Ticket2\V1\Rest\ShowTickets\ShowTicketsCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'ticket2.rest.show-tickets',
                'route_identifier_name' => 'show_tickets_id',
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
