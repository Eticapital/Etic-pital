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
        return true;
    }
}
