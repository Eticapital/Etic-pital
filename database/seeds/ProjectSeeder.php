<?php

use App\Models\Project;
use App\Models\ProjectDocument;
use App\Models\ProjectKpi;
use App\Models\ProjectTeam;
use App\Models\Reward;
use App\Models\Sector;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Project::class, 10)->create()->each(function ($project) {
            $project->sectors()->sync(
                Sector::all()->pluck('id')->random(rand(1, Sector::count()))
            );

            $project->rewards()->sync(
                Reward::all()->pluck('id')->random(rand(1, Reward::count()))
            );

            factory(ProjectTeam::class, rand(0, 4))->create(['project_id' => $project->id]);

            factory(ProjectKpi::class, rand(0, 5))->create(['project_id' => $project->id]);

            factory(ProjectDocument::class, rand(0, 15))->create(['project_id' => $project->id]);
        });
    }
}
