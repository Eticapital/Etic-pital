<?php

namespace App\Policies;

use App\User;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can index the roles
     *
     * @param  \App\User  $user
     * @param  \App\Models\
     * Role  $role
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->is_root || $user->can('roles.index');
    }

    /**
     * Determine whether the user can view the role.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Role  $role
     *
     * @return mixed
     */
    public function view(User $user, Role $role)
    {
        return $user->is_root || $user->can('roles.view');
    }

    /**
     * View alias
     * @param  User   $user
     * @param  Role   $role
     *
     * @return boolean
     */
    public function show(User $user, Role $role)
    {
        return $this->view($user, $role);
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param  \App\User  $user
     * @return booelan
     */
    public function create(User $user)
    {
        return $user->is_root || $user->can('roles.create');
    }

    /**
     * Create alias
     *
     * @param  User   $user
     * @return boolean
     */
    public function store(User $user)
    {
        return $this->create($user);
    }

    /**
     * Determine whether the user can update the role.
     *
     * @param  \App\User  $user
     * @param  \App\Models\
     * Role  $role
     * @return mixed
     */
    public function update(User $user, Role $role)
    {
        return ($user->is_root || (!$role->is_system && $user->can('roles.update'))) && $this->show($user, $role);
    }

    /**
     * Update alias
     * @param  User   $user
     * @param  Role   $role
     *
     * @return boolean
     */
    public function edit(User $user, Role $role)
    {
        return $this->update($user, $role);
    }

    /**
     * Determine whether the user can delete the role.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Role  $role
     * @return mixed
     */
    public function delete(User $user, Role $role)
    {
        return !$role->is_system && ($user->is_root || $user->can('roles.delete'));
    }

    /**
     * Puede listar los usuarios
     *
     * @param  User   $user
     * @param  Role   $role
     * @return void
     */
    public function users(User $user, Role $role)
    {
        return $user->is_root || $user->can('roles.users');
    }

    /**
     * Puede actualizar un permiso de un rol
     *
     * @param  User   $user
     * @param  Role   $role
     * @return boolean
     */
    public function usersToggle(User $user, Role $role)
    {
        return $user->is_root || $user->can('roles.users.toggle');
    }

    /**
     * Delete alias
     * @param  User   $user
     * @param  Role   $role
     *
     * @return booelan
     */
    public function destroy(User $user, Role $role)
    {
        return $this->delete($user, $role);
    }

    /**
     * Puede listar los permisos de un rol
     *
     * @param  User   $user
     * @param  Role   $role
     * @return boolean
     */
    public function permissions(User $user, Role $role)
    {
        return $user->is_root || $user->can('roles.permissions');
    }

    /**
     * Puede actualizar un permiso de un rol
     *
     * @param  User   $user
     * @param  Role   $role
     * @return boolean
     */
    public function permissionsToggle(User $user, Role $role)
    {
        return $user->is_root || $user->can('roles.permissions.toggle');
    }
}
