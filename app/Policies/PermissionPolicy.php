<?php

namespace App\Policies;

use App\Models\Permission;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    /**
     * Un usuario puede listar un permisos
     *
     * @param  User       $user
     * @param  Permission $permission
     *
     * @return boolean
     */
    public function index(User $user)
    {
        return $user->is_root || $user->can('permission.index');
    }

    /**
     * Un usuario puede actualizar un permiso
     *
     * @param  User       $user
     * @param  Permission $permission
     *
     * @return boolean
     */
    public function toggle(User $user, Permission $permission)
    {
        return $user->is_root || $user->can('permission.toggle');
    }
}
