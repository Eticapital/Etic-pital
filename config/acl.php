<?php

return [
    'modules' => [
        'users' => 'Usuarios',
        'roles' => 'Grupos de Usuario',
        'projects' => 'Proyectos',
    ],

    'permissions' => [
        // Resource Permissions
        'users' => [
            'index' => 'Listar',
            'view' => 'Ver',
            'create' => 'Crear',
            'update' => 'Actualizar',
            'delete' => 'Eliminar',
        ],

        // Resource Permissions
        'projects' => [
            'index' => 'Listar',
            'view' => 'Ver',
            'create' => 'Crear',
            'update' => 'Actualizar',
            'delete' => 'Eliminar',
        ],

        'roles' => [
            'index' => 'Listar',
            'view' => 'Ver permisos',
            'create' => 'Crear',
            'update' => 'Actualizar',
            'delete' => 'Eliminar',
            'permissions' => 'Listar permisos',
            'permissions.toggle' => 'Actualizar permiso',
            'users' => 'Listar usuarios',
            'users.toggle' => 'Agregar/Quitar usuarios',
        ],

        'show-debugbar' => 'Ejemplo de Permiso'
    ]
];
