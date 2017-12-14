<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectInvestmentRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectInvestmentController extends Controller
{
    public function create(Project $project)
    {
        return view('investment.create')->with(compact('project'));
    }

    public function store(Project $project, ProjectInvestmentRequest $request)
    {
        flash('¡Tu promesa de inversión fue registrada correctamente! Te contactaremos pronto para informate de próximos pasos.');



        return [
            'investment' => $request->all(),
            'redirect_to' => route('projects.show', $project->slug),
        ];
    }
}
