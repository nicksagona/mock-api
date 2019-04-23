<?php

return [
    'database' => include __DIR__ . '/database.php',
    'routes'   => [
        '/users[/]' => [
            'controller' => 'Mock\Api\Http\Controller\IndexController',
            'action'     => 'users'
        ],
        '/users/count[/]' => [
            'controller' => 'Mock\Api\Http\Controller\IndexController',
            'action'     => 'usersCount'
        ],
        '*'    => [
            'controller' => 'Mock\Api\Http\Controller\IndexController',
            'action'     => 'error'
        ]
    ],
    'http_options_headers' => [
        'Access-Control-Allow-Origin'  => '*',
        'Access-Control-Allow-Headers' => 'Accept, Authorization, Content-Type, X-Resource, X-Permission',
        'Access-Control-Allow-Methods' => 'HEAD, OPTIONS, GET, PUT, POST, PATCH, DELETE',
        'Content-Type'                 => 'application/json'
    ]
];