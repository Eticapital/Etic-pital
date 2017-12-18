<?php

namespace App\Listeners;

use App\Events\NewProjectRegistered;
use App\Notifications\NewProjectRegisteredNotification;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NewProjectRegisteredListener
{
    /**
     * Handle the event.
     *
     * @param  NewProjectRegistered  $event
     * @return void
     */
    public function handle(NewProjectRegistered $event)
    {
        $project = $event->project;

        $users = User::where('email', config('eticapital.admin_emails'))->get();
        Notification::send($users, new NewProjectRegisteredNotification($project));
    }
}
