<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

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
        $data = $request->all();

        // Para procesar por el trait de imagenes lo convierto a un
        // objecto tipo \Intervention\Image\Image
        if (isset($data['photo']) && Storage::disk('public')->exists('tmp/' . $data['photo'])) {
            $data['photo'] = Image::make(storage_path('app/public/tmp/' . $data['photo']));
        }

        return tap(auth()->user()->projects()->create($data), function ($project) {
            $project->sectors = request()->input('sectors');
            $project->rewards = request()->input('rewards');
            $project->kpis = request()->input('kpis');
            $project->team = request()->input('team');
            $project->company_documents = request()->input('company_documents');
            $project->key_documents = request()->input('key_documents');
            $project->extra_documents = request()->input('extra_documents');
        });
    }

    public function show(Project $project)
    {
        if (!$project->published_at || !$project->published_at > Carbon::now()) {
            abort(404, 'Proyecto no encontrado');
        }

        if (request()->ajax()) {
            return $project->toFormArray();
        }

        $team = $project->team()->get();
        $kpis = $project->kpis()->get();
        $documents = $project->documents()->limit(6)->get();

        return view('projects.show')->with(compact('project', 'team', 'kpis', 'documents'));
    }

    /**
     * Encuentra las imagenes y video de un proyecto
     *
     * @return json
     */
    public function media()
    {
        #code
    }
}
