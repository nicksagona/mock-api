<?php

return [
    'database' => include __DIR__ . '/database.php',
    'auth'     => false,
    'auth_key' => null,
    'routes'   => [
        'options,get' => [
            '/users[/:id]' => [
                'controller' => 'Mock\Api\Http\Controller\IndexController',
                'action'     => 'index'
            ],
            '/users/count[/]' => [
                'controller' => 'Mock\Api\Http\Controller\IndexController',
                'action'     => 'count'
            ],
            '/users/fields[/]' => [
                'controller' => 'Mock\Api\Http\Controller\IndexController',
                'action'     => 'fields'
            ]
        ],
        'options,post' => [
            '/users[/]' => [
                'controller' => 'Mock\Api\Http\Controller\IndexController',
                'action'     => 'create'
            ]
        ],
        'options,put' => [
            '/users/:id' => [
                'controller' => 'Mock\Api\Http\Controller\IndexController',
                'action'     => 'update'
            ]
        ],
        'options,delete' => [
            '/users[/:id]' => [
                'controller' => 'Mock\Api\Http\Controller\IndexController',
                'action'     => 'delete'
            ]
        ],
        '*' => [
            '*' => [
                'controller' => 'Mock\Api\Http\Controller\IndexController',
                'action'     => 'error'
            ]
        ]
    ],
    'http_options_headers' => [
        'Access-Control-Allow-Origin'  => '*',
        'Access-Control-Allow-Headers' => 'Accept, Authorization, Content-Type, X-Resource, X-Permission',
        'Access-Control-Allow-Methods' => 'HEAD, OPTIONS, GET, PUT, POST, PATCH, DELETE',
        'Content-Type'                 => 'application/json'
    ]
];