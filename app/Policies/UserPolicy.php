<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the =User.
     *
     * @param  \App\User  $logged_user
     * @param  \App\User  $user
     *
     * @return boolean
     */
    public function index(User $logged_user)
    {
        return $logged_user->is_root || $logged_user->can('users.index');
    }

    /**
     * Determine si puede ver los datos de otro usuario
     *
     * @param  \App\User  $logged_user
     * @param  \App\User  $user
     *
     * @return boolean
     */
    public function view(User $logged_user, User $user)
    {
        return $logged_user->is_root || $logged_user->can('roles.view');
    }

    /**
     * View alias
     * @param  User   $user
     * @param  User   $role
     *
     * @return boolean
     */
    public function show(User $logged_user, User $user)
    {
        return $this->view($logged_user, $user);
    }

    /**
     * Determine whether the user can crate users
     *
     * @param  \App\User  $logged_user
     * @return booelan
     */
    public function create(User $logged_user)
    {
        return $logged_user->is_root || $logged_user->can('users.create');
    }

    /**
     * Create alias
     *
     * @param  User   $logged_user
     * @return boolean
     */
    public function store(User $logged_user)
    {
        return $this->create($logged_user);
    }

    /**
     * Update an user
     *
     * @param  User   $logged_user
     * @param  User   $user
     *
     * @return boolean
     */
    public function update(User $logged_user, User $user)
    {
        return $logged_user->is_root || $logged_user->can('users.update');
    }

    /**
     * Actualizar el status
     *
     * @param  User   $logged_user
     * @param  User   $user
     *
     * @return boolean
     */
    public function status(User $logged_user, User $user)
    {
        return $this->update($logged_user, $user);
    }

    /**
     * Delete an user
     *
     * @param  User   $logged_user
     * @param  User   $user
     *
     * @return boolean
     */
    public function delete(User $logged_user, User $user)
    {
        return ($logged_user->is_root || $logged_user->can('users.delete')) && !$user->is_system;
    }

    /**
     * Delete user alias
     *
     * @param  User   $logged_user
     * @param  User   $user
     *
     * @return boolean
     */
    public function destroy(User $logged_user, User $user)
    {
        return $this->delete($logged_user, $user);
    }

    /**
     * Si el usuario puede cargar avatar, se hereda del permiso de crear
     *
     * @param  User   $logged_user
     *
     * @return boolean
     */
    public function avatar(User $logged_user)
    {
        return $this->create($logged_user);
    }
}
