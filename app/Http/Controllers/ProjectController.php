<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::featuredFirst()
            ->published()
            ->paginate(5);

        return view('invertir')->with(compact('projects'));
    }

    public function store(ProjectRequest $request)
    {
        return $request->all();
    }

    public function show(Project $project)
    {
        if (!$project->published_at || !$project->published_at > Carbon::now()) {
            abort(404, 'Proyecto no encontrado');
        }

        return view('proyecto')->with(compact('project'));
    }
}
