<?php

namespace App\Listeners;

use App\Events\ProjectPublished;
use App\Notifications\ProjectPublishedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProjectPublishedListener
{
   /**
     * Handle the event.
     *
     * @param  ProjectPublished  $event
     * @return void
     */
    public function handle(ProjectPublished $event)
    {
        $project = $event->project;

        if (!$project->notification_project_approved_sended) {
            $project->owner->notify(new ProjectPublishedNotification($project));
            $project->notification_project_approved_sended = true;
            $project->save();
        }
    }
}
