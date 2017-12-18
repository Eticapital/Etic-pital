<?php

return [
    'modules' => [
        'users' => 'Usuarios',
        'roles' => 'Grupos de Usuario',
        'projects' => 'Proyectos',
        'investments' => 'Promesas de inversión',
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
            'publish' => 'Publicar',
            'reject' => 'Rechazar',
            'finish' => 'Finalizar',
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

        // Resource Permissions
        'investments' => [
            'index' => 'Listar',
            'view' => 'Ver',
            'create' => 'Crear',
            'update' => 'Actualizar',
            'delete' => 'Eliminar',
            'accept' => 'Aceptar',
            'reject' => 'Rechazar',
            'download' => 'Descargar documentos',
        ],

        'show-debugbar' => 'Ejemplo de Permiso'
    ]
];
