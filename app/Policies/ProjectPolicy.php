<?php

namespace App\Policies;

use App\Models\Project;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the =User.
     *
     * @param  \App\Models\Project  $user
     * @param  \App\Models\Project  $user
     *
     * @return boolean
     */
    public function index(User $user)
    {
        return $user->is_root || $user->can('projects.index');
    }

    /**
     * Determina si puede ver los datos de un proyecto
     *
     * @param  App\User   $user
     * @param  App\Models\Project   $user
     *
     * @return boolean
     */
    public function view(User $user, Project $project)
    {
        if ($project->is_published) {
            return true;
        }

        // Si es dueño siempre lo puede ver salvo que este rechazado
        if ($user->id === $project->owner_id) {
            return !$project->is_rejected;
        }

        return $user->is_root || $user->can('roles.view');
    }

    /**
     * View alias
     * @param  App\User   $user
     * @param  App\Models\Project   $user
     *
     * @return boolean
     */
    public function show(User $user, Project $project)
    {
        return $this->view($user, $project);
    }

    /**
     * Determine whether the user can crate users
     *
     * @param  App\User  $user
     * @return booelan
     */
    public function create(User $user)
    {
        return $user->is_root || $user->can('projects.create');
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
     * Update a project
     *
     * @param  App\User   $user
     * @param  App\Models\Project   $user
     *
     * @return boolean
     */
    public function update(User $user, Project $project)
    {
        if (!$this->view($user, $project)) {
            return false;
        }

        // Si el usuario tiene permisos para hacer el ajuste
        if ($user->is_root || $user->can('projects.update')) {
            return true;
        }

        // SI no tiene permisos solo lo puede editar si el proyecto no está publicado
        // y es el dueño del proyecto
        return ($user->id === $project->owner_id && $project->is_pending);
    }

    /**
     * show edit view
     *
     * @param  App\User   $user
     * @param  App\Models\Project   $user
     *
     * @return boolean
     */
    public function edit(User $user, Project $project)
    {
        return $this->update($user, $project);
    }

    /**
     * Delete an user
     *
     * @param  App\User   $user
     * @param  App\Models\Project   $user
     *
     * @return boolean
     */
    public function delete(User $user, Project $project)
    {
        return $user->is_root || $user->can('projects.delete');
    }

    /**
     * Delete user alias
     *
     * @param  User   $user
     * @param  Project   $user
     *
     * @return boolean
     */
    public function destroy(User $user, Project $project)
    {
        return $this->delete($user, $project);
    }
}
