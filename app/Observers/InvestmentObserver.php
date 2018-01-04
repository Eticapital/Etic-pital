<?php

namespace App\Observers;

use App\Events\NewUserCreatedFromInvestment;
use App\Models\Investment;

class InvestmentObserver
{
    /**
     * Antes de que se cree una inversión
     *
     * @param  \App\Models\Investment $investment
     * @return void
     */
    public function creating(Investment $investment)
    {
        if (auth()->id()) {
            $investment->owner_id = auth()->id();
        } else {
            // Voy a crear un usuario con los datos de la inversión (solo aplicará los qe tiene en común
            // teléfono, email, etc)
            $user_data = $investment->toArray();
            $user_data['password'] = bcrypt(uniqid());
            $user = \App\User::firstOrCreate(['email' => $investment->email], $user_data);
            event(new NewUserCreatedFromInvestment($user, $investment));
            $investment->owner_id = $user->id;
        }
    }

    /**
     * Listen to the User deleting event.
     *
     * @param  \App\Models\Investment $investment
     * @return void
     */
    public function deleting(Investment $investment)
    {
        //
    }
}