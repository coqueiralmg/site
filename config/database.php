<?php

return [
    /**
     * Connection information used by the ORM to connect
     * to your application's datastores.
     * Do not use periods in database name - it may lead to error.
     * See https://github.com/cakephp/cakephp/issues/6471 for details.
     * Drivers include Mysql Postgres Sqlite Sqlserver
     * See vendor\cakephp\cakephp\src\Database\Driver for complete list
     */
    'Datasources' => [
        'developer' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,
            'host' => 'localhost',
            //'port' => 'non_standard_port_number',
            'username' => 'developer',
            'password' => '123456',
            'database' => 'coqueiral',
            'encoding' => 'latin1',
            //'timezone' => 'UTC',
            'flags' => [],
            'cacheMetadata' => true,
            'log' => true,
            'quoteIdentifiers' => false,
            //'init' => ['SET GLOBAL innodb_stats_on_metadata = 0'],
            'url' => env('DATABASE_URL', null),
        ],

        'release' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,
            'host' => 'localhost',
            //'port' => 'non_standard_port_number',
            'username' => 'mggovbr_dingo',
            'password' => 'NMOGxyhmhrUUF5PDoS',
            'database' => 'mggovbr_coqueiral',
            'encoding' => 'latin1',
            //'timezone' => 'UTC',
            'cacheMetadata' => true,
            'quoteIdentifiers' => false,
            'log' => true,
            //'init' => ['SET GLOBAL innodb_stats_on_metadata = 0'],
            'url' => env('DATABASE_URL', null),
        ],
    ],
    'Database' => [
        'datasource' => 'developer'
    ]
];
