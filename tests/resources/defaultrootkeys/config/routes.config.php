<?php

return [
    'routes' => [

        '/a' => [
            'method' => 'POST',
            'action' => 'a_action',
            'controller' => 'AController'
        ],
        
        '/b' => [
            'action' => 'b_action',
            'controller' => 'BController'
        ],
        
         '/c' => [
            'method' => 'POST',
            'controller' => 'CController'
        ],
        
        '/d' => [
            'controller' => 'DController'
        ]

    ]
];
