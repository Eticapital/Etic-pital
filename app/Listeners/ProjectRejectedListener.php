<?php

namespace App\Listeners;

use App\Events\ProjectRejected;
use App\Notifications\ProjectRejectedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProjectRejectedListener
{
    /**
     * Handle the event.
     *
     * @param  ProjectRejected  $event
     * @return void
     */
    public function handle(ProjectRejected $event)
    {
        $project = $event->project;

        if (!$project->notification_project_rejected_sended) {
            $project->owner->notify(new ProjectRejectedNotification($project));
            $project->notification_project_rejected_sended = true;
            $project->save();
        }
    }
}
