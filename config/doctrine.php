<?php

return [
    'managers' => [
        'default' => [
            'dev' => env('APP_DEBUG', false),
            'meta' => 'attributes',
            'connection' => env('DB_CONNECTION', 'pgsql'),
            'namespaces' => [],
            'paths' => [
                base_path('app/Entities'),
            ],
            'repository' => Doctrine\ORM\EntityRepository::class,
            'proxies' => [
                'namespace' => 'DoctrineProxies',
                'path' => storage_path('proxies'),
                'auto_generate' => env('DOCTRINE_PROXY_AUTOGENERATE', false),
            ],
            'events' => [
                'listeners' => [],
                'subscribers' => [],
            ],
            'filters' => [],
            'mapping_types' => [],
        ],
    ],
    'extensions' => [
        // LaravelDoctrine\ORM\Extensions\TablePrefix\TablePrefixExtension::class,
        // LaravelDoctrine\Extensions\Timestamps\TimestampableExtension::class,
        // LaravelDoctrine\Extensions\SoftDeletes\SoftDeleteableExtension::class,
        // LaravelDoctrine\Extensions\Sluggable\SluggableExtension::class,
        // LaravelDoctrine\Extensions\Sortable\SortableExtension::class,
        // LaravelDoctrine\Extensions\Tree\TreeExtension::class,
        // LaravelDoctrine\Extensions\Loggable\LoggableExtension::class,
        // LaravelDoctrine\Extensions\Blameable\BlameableExtension::class,
        // LaravelDoctrine\Extensions\IpTraceable\IpTraceableExtension::class,
        // LaravelDoctrine\Extensions\Translatable\TranslatableExtension::class
    ],
    'custom_types' => [],
    'custom_datetime_functions' => [],
    'custom_numeric_functions' => [],
    'custom_string_functions' => [],
    'custom_hydration_modes' => [],
    'logger' => env('DOCTRINE_LOGGER', false),
    'cache' => [
        'second_level' => false,
        'default' => env('DOCTRINE_CACHE', 'array'),
        'namespace' => null,
        'metadata' => [
            'driver' => env('DOCTRINE_METADATA_CACHE', env('DOCTRINE_CACHE', 'array')),
            'namespace' => 'DoctrineMetaData',
        ],
        'query' => [
            'driver' => env('DOCTRINE_QUERY_CACHE', env('DOCTRINE_CACHE', 'array')),
            'namespace' => 'DoctrineQuery',
        ],
        'result' => [
            'driver' => env('DOCTRINE_RESULT_CACHE', env('DOCTRINE_CACHE', 'array')),
            'namespace' => 'DoctrineResult',
        ],
    ],
    'gedmo' => [
        'all_mappings' => false,
    ],
    'doctrine_presence_verifier' => true,
    'notifications' => [
        'channel' => 'database',
    ],
];
