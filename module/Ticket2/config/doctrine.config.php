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
                    'User\Entity' => 'user_entity',
                    'Ticket2\Entity' => 'ticket_entity',

                ]
            ],
            'configuration' => [
                'orm_default' => [
                    'filters' => [
                        'soft-deleteable' => 'Gedmo\SoftDeleteable\Filter\SoftDeleteableFilter'
                    ]
                ]
            ]
        ]
    ]
];
