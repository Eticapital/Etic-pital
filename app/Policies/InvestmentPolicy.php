<?php

namespace App\Policies;

use App\Models\Investment;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvestmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determina si puede aceptar una inversión
     *
     * @param  App\User   $user
     * @param  App\Models\Investment   $investment
     *
     * @return boolean
     */
    public function accept(User $user, Investment $investment)
    {
        if ($investment->investment_status === Investment::STATUS_ACCEPTED) {
            return false;
        }

        if ($investment->project->owner_id === $user->id) {
            return true;
        }

        return $user->is_root || $user->can('investments.accept');
    }

    /**
     * Determina si puede no aceptar una inversión
     *
     * @param  App\User   $user
     * @param  App\Models\Investment   $investment
     *
     * @return boolean
     */
    public function reject(User $user, Investment $investment)
    {
        if ($investment->investment_status === Investment::STATUS_REJECTED) {
            return false;
        }

        if ($investment->project->owner_id === $user->id) {
            return true;
        }

        return $user->is_root || $user->can('investments.reject');
    }

    /**
     * Determina si puede eliminar una inversión
     *
     * @param  App\User   $user
     * @param  App\Models\Investment   $investment
     *
     * @return boolean
     */
    public function delete(User $user, Investment $investment)
    {
        return $user->is_root || $user->can('investments.delete');
    }
}
