<?php
return [
    'doctrine' => [
        'driver' => [
            'ticket_entity' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/orm']
            ],
            'orm_default' => [
                'drivers' => [
                    'Ticket2\Entity' => 'ticket_entity',

                ]
            ]
        ]
    ]
];