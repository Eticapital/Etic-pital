<?php

return [
    'role_structure' => [
        'root' => [
            'users' => 'i,c,r,u,d',
            'roles' => 'i,c,r,u,d',
            'profile' => 'r,u'
        ],
        'admin' => [
            'users' => 'i,c,r,u,d',
            'profile' => 'r,u'
        ],
        'user' => [
            'profile' => 'r,u'
        ],
    ],
    'permission_structure' => [
        // 'alfonso' => [
        //     'profile' => 'c,r,u'
        // ],
    ],
    'permissions_map' => [
        'i' => 'index',
        'c' => 'create',
        'r' => 'view',
        'u' => 'update',
        'd' => 'delete',
    ]
];
