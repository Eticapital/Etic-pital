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

        // Si es inversionista puede descargar
        if ($user->is_investor) {
            return true;
        }

        $project = $document->project;
        return ($project->owner_id === $user->id);
    }
}
