<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NavController extends Controller
{
    public function get()
    {
        $nav = [
            [
                'title' => 'Inicio',
                'text' => 'Inicio',
                'route' => 'home',
                'icon' => 'home',
                'exact' => true,
            ],
            [
                'title' => 'Mi Cuenta',
                'text' => 'Mi cuenta',
                'route' => 'account.index',
                'hide' => true,
                'items' => [
                    [
                        'title' => 'Actualizar datos de mi cuenta',
                        'icon' => 'pencil2',
                        'text' => 'Actualizar datos de mi cuenta',
                        'route' => 'account.edit',
                        'in_top_menu' => true,
                        'return' => true,
                    ],
                    [
                        'title' => 'Actualizar mi contraseña',
                        'icon' => 'key',
                        'text' => 'Actualizar mi contraseña',
                        'route' => 'account.password',
                        'in_top_menu' => true,
                        'return' => true,
                    ],
                ]
            ],
            [
                'title' => 'Ver usuarios',
                'icon' => 'user',
                'text' => 'Usuarios',
                'route' => 'users.index',
                'searchable' => true,
                'hide' => true,
                'permission' => ['index', \App\User::class],
                'items' => [
                    [
                        'title' => 'Nuevo usuario',
                        'icon' => 'plus',
                        'text' => 'Nuevo usuario',
                        'route' => 'users.create',
                        'permission' => ['create', \App\User::class],
                        'in_top_menu' => true,
                        'return' => true,
                    ],
                    [
                        'title' => 'Perfil {name}',
                        'text' => '{name}',
                        'route' => 'users.show',
                        'hide' => true,
                        'return' => true,
                        'items' => [
                            [
                                'title' => 'Editar {name}',
                                'icon' => 'pencil2',
                                'text' => 'Editar',
                                'route' => 'users.edit',
                                'hide' => true,
                                'return' => true,
                                'in_top_menu' => true,
                            ],
                        ]
                    ],
                ]
            ],

            // Grupos de usuariios
            [
                'title' => 'Grupos de usuarios',
                'icon' => 'lock',
                'text' => 'Grupos de usuarios',
                'route' => 'roles.index',
                'permission' => ['index', \App\Models\Role::class],
                'searchable' => true,
                'hide' => true,
                'items' => [
                    [
                        'title' => 'Nuevo grupo',
                        'icon' => 'plus',
                        'text' => 'Nuevo grupo',
                        'route' => 'roles.create',
                        'in_top_menu' => true,
                        'return' => true,
                        'permission' => ['create', \App\Models\Role::class],
                    ],
                    [
                        'title' => 'Editar grupo: {display_name}',
                        'icon' => 'pencil2',
                        'text' => 'Editar grupo: {display_name}',
                        'route' => 'roles.edit',
                        'hide' => true,
                        'return' => true,
                    ],
                    [
                        'title' => '{display_name}: Definir permisos',
                        'icon' => 'checkmark',
                        'text' => '{display_name}: Permisos',
                        'route' => 'roles.permissions',
                        'hide' => true,
                        'return' => true,
                    ],
                    [
                        'title' => 'Usuarios en el grupo: "{display_name}"',
                        'icon' => 'group',
                        'text' => '{display_name}: Usuarios',
                        'route' => 'roles.users',
                        'hide' => true,
                        'return' => true,
                        'searchable' => true,
                    ],
                ]
            ],

            [
                'title' => 'Proyectos',
                'icon' => 'tree',
                'text' => 'Proyectos',
                'route' => 'projects.index',
                'searchable' => true,
                'hide' => false,
                'permission' => ['index', \App\Models\Project::class],
                'items' => [
                    [
                        'title' => 'Nuevo proyecto',
                        'icon' => 'plus',
                        'text' => 'Nuevo proyecto',
                        'route' => 'projects.create',
                        'permission' => ['create', \App\Models\Project::class],
                        'in_top_menu' => true,
                        'return' => true,
                        'hide' => true,
                    ],
                    [
                        'title' => 'Perfil {name}',
                        'text' => '{name}',
                        'route' => 'projects.show',
                        'hide' => true,
                        'return' => true,
                        'items' => [
                            // [
                            //     'title' => 'Administrar {name}',
                            //     'icon' => 'wrench',
                            //     'text' => 'Administrar',
                            //     'route' => 'projects.edit',

                            //     'hide' => true,
                            //     'return' => true,
                            //     'in_top_menu' => true,
                            // ],
                            [
                                'title' => 'Editar',
                                'icon' => 'pencil2',
                                'text' => 'Editar',
                                'href' => '/projects/{id}/edit?return=admin',
                                'hide' => true,
                                'return' => true,
                                'in_top_menu' => true,
                            ],
                        ]
                    ],
                ]
            ],

            [
                'title' => 'Inversiones',
                'icon' => 'coins',
                'text' => 'Inversiones',
                'route' => 'investments.index',
                'searchable' => true,
                'hide' => false,
                'permission' => ['index', \App\Models\Investment::class],
                'items' => [
                    [
                        'title' => 'Nuevo promesa de inversión',
                        'icon' => 'plus',
                        'text' => 'Nueva promesa de inversión',
                        'route' => 'investments.create',
                        'permission' => ['create', \App\Models\Investment::class],
                        'hide' => true,
                        'in_top_menu' => true,
                        'return' => true,
                    ],
                    [
                        'title' => 'Editar {name}',
                        'icon' => 'pencil2',
                        'text' => 'Editar',
                        'route' => 'investments.edit',
                        'hide' => true,
                        'return' => true,
                        'in_top_menu' => false,
                    ],
                ]
            ],
        ];

        // Filtro los elementos segun los permisos del usuario
        // return $this->filterNav($nav);
        return $nav;
    }

    private function filterNav($nav)
    {
        $nav = collect($nav)->filter(function ($subnav) {
            // Si tiene un permiso reviso si tengo que filtrar los datos
            if (array_key_exists('permission', $subnav) && is_array($subnav['permission'])) {
                // Tiene multiples permisos
                if (is_array($subnav['permission'][0])) {
                    $atLeastCanOne = collect($subnav['permission'])->contains(function ($permission) {
                        list($permission, $model) = $permission;
                        return auth()->user()->policyCan($permission, $model);
                    });

                    if (!$atLeastCanOne) {
                        return false;
                    }
                } else {
                    list($permission, $model) = $subnav['permission'];
                    if (!auth()->user()->policyCan($permission, $model)) {
                        return false;
                    }
                }
            }

            return true;
        // Reinicia los indices
        })->values();

        // Filtro los hijos
        $nav = $nav->map(function ($subnav, $index) {
            if (array_key_exists('items', $subnav)) {
                $subnav['items'] = $this->filterNav($subnav['items']);
            }

            return $subnav;
        });

        return $nav->toArray();
    }
}
