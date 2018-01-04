<?php

namespace App\Listeners;

use App\Events\ProjectFinished;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProjectFinishedListener implements ShouldQueue
{

    /**
     * Handle the event.
     *
     * @param  ProjectFinished  $event
     * @return void
     */
    public function handle(ProjectFinished $event)
    {
        $project = $event->project;
    }
}
