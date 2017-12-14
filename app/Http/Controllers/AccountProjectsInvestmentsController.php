<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class AccountProjectsInvestmentsController extends Controller
{
    public function index(Project $project)
    {
        $this->authorize('investments', $project);
        $investments = $project->investments()->paginate(10);
        return view('account.investments')->with(compact('investments', 'project'));
    }
}
