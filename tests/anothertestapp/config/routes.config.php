<?php

return [
    'routes' => [

        '/hello' => [
            'action' => 'index_action',
            'controller' => 'HelloController'
        ],

        '/foo' => [
            'action' => 'foo_action',
            'controller' => 'HelloController'
        ],

        '/hi' => [
            'action' => 'index_action',
            'controller' => 'HiController'
        ],

        '/bar' => [
            'action' => 'bar_action',
            'controller' => 'HiController'
        ]

    ]
];
