<?php

namespace App\Listeners;

use App\Events\NewProjectInvestment;
use App\Notifications\NewProjectInvestmentNotification;
use App\Notifications\ProjectInvestmentReceivedNotification;
use App\Notifications\ProjectInvestmentSendedNotification;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NewProjectInvestmentListener
{
    /**
     * Handle the event.
     *
     * @param  NewProjectInvestment  $event
     * @return void
     */
    public function handle(NewProjectInvestment $event)
    {
        $investment = $event->investment;
        $investment->owner->notify(new ProjectInvestmentSendedNotification($investment));
        $investment->project->owner->notify(new ProjectInvestmentReceivedNotification($investment));

        $users = User::where('email', config('eticapital.admin_emails'))->get();
        Notification::send($users, new NewProjectInvestmentNotification($investment));
    }
}
