<?php

return [
    'default' => [
        'objectManager' => 'Doctrine\ORM\EntityManager',
        'executor' => Doctrine\Common\DataFixtures\Executor\ORMExecutor::class,
        'purger' => Doctrine\Common\DataFixtures\Purger\ORMPurger::class,
        'fixtures' => [
            Database\Fixtures\BloggerFixtures::class,
        ],
    ],
];
