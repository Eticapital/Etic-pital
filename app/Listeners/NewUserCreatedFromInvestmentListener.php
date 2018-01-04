<?php

namespace App\Listeners;

use App\Events\NewUserCreatedFromInvestment;
use App\Notifications\ActivationEmailToUsersNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;

class NewUserCreatedFromInvestmentListener
{

    /**
     * Handle the event.
     *
     * @param  NewUserCreatedFromInvestment  $event
     * @return void
     */
    public function handle(NewUserCreatedFromInvestment $event)
    {
        $user = $event->user;
        $investment = $event->investment;

        $user->activation_token = Str::random(60);
        $user->save();

        $user->notify(new ActivationEmailToUsersNotification());
    }
}
