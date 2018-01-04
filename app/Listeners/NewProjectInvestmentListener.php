<?php

namespace App\Listeners;

use App\Events\NewProjectInvestment;
use App\Notifications\ProjectInvestmentReceivedNotification;
use App\Notifications\ProjectInvestmentSendedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
    }
}
