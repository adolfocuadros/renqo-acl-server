<?php
return  [
    'default' => 'mongodb',

    'connections' => [
        'mysql' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST', 'localhost'),
            'database'  => env('DB_DATABASE', ''),
            'username'  => env('DB_USERNAME', ''),
            'password'  => env('DB_PASSWORD', ''),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],

        'mongodb' => [
            'driver'   => 'mongodb',
            'host'     => 'localhost',
            'port'     => '27017',
            'database' => 'test',
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'use_mongo_id' => false,
            'options' => [
                'db' => 'admin', // Sets the authentication database required by mongo 3
                //['replicaSet' => 'replicaSetName'], // Connect to multiple servers or replica sets
            ]
        ],

    ],
];