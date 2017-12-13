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
        $this->authorize('index', Project::class);

        $query = request()->input('query')
            ? Project::search(request()->input('query'))
            : Project::latest();

        $results = $query->paginate(request()->input('per_page', 10));

        if (request()->input('appends')) {
            return tap($results)->each(function ($project) {
                $project->lazyAppend(request()->input('appends'));
            });
        }

        return $results;
    }

    public function create()
    {
        return view('projects.create');
    }

    public function edit(Project $project)
    {
        $this->authorize('edit', $project);
        return view('projects.edit')->with(compact('project'));
    }

    public function show(Project $project)
    {
        if (!auth()->user()) {
            if (!$project->published_at) {
                abort(404, 'Proyecto no encontrado');
            }
        } else {
            $this->authorize('show', $project);
        }

        if (request()->ajax()) {
            if (request()->input('appends')) {
                $project->lazyAppend(request()->input('appends'));
            }

            return $project;
        }

        $team = $project->team()->get();
        $kpis = $project->kpis()->get();
        $documents = $project->documents()->limit(6)->get();

        return view('projects.show')->with(compact('project', 'team', 'kpis', 'documents'));
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        return tap($project)->delete();
    }

    public function store(ProjectRequest $request)
    {
        $this->authorize('create', Project::class);

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

    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $data = $this->validate($request, [
            'name' => 'required',
            'password' => 'sometimes|nullable|confirmed',
            'email' => 'email|unique:users,email,'.$project->id,
        ]);

        if (!$data['password']) {
            unset($data['password']);
        }

        return tap($project)->update($data);
    }

    public function publicList()
    {
        $projects = Project::featuredFirst()
            ->published()
            ->paginate(5);

        return view('invertir')->with(compact('projects'));
    }



    // public function show(Project $project)
    // {
    //     if (!$project->published_at || !$project->published_at > Carbon::now()) {
    //         abort(404, 'Proyecto no encontrado');
    //     }

    //     if (request()->ajax()) {
    //         return $project->toFormArray();
    //     }
    // }
}
