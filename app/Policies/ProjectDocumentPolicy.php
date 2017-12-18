<?php

namespace App\Policies;

use App\Models\ProjectDocument;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectDocumentPolicy
{
    use HandlesAuthorization;


    public function download(User $user, ProjectDocument $document)
    {
        if ($user->is_root || $user->can('investments.download')) {
            return true;
        }

        $project = $document->project;

        if ($project->owner_id === $user->id) {
            return true;
        }

        // Si es inversionista
        return $user->isInvestorOf($project);
    }
}
