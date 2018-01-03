<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\Project;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getData()
    {
        $total_pending_projects = Project::unpublished()->count();
        $goal_pending_projects = Project::unpublished()->get()->sum(function ($project) {
            return $project->goal;
        });
        $total_published_projects = Project::published()->count();
        $goal_published_projects = Project::published()->get()->sum(function ($project) {
            return $project->goal;
        });
        $collected_published_projects = Project::published()->get()->sum(function ($project) {
            return $project->collected;
        });
        $total_rejected_projects = Project::rejected()->count();
        $goal_rejected_projects = Project::rejected()->get()->sum(function ($project) {
            return $project->goal;
        });

        $total_accepted_investments = Investment::accepted()->count();
        $value_accepted_investments = Investment::accepted()->sum('amount');

        $total_pending_investments = Investment::new()->count();
        $value_pending_investments = Investment::new()->sum('amount');

        $total_rejected_investments = Investment::rejected()->count();
        $value_rejected_investments = Investment::rejected()->sum('amount');

        return compact(
            'total_pending_projects',
            'goal_pending_projects',
            'total_published_projects',
            'goal_published_projects',
            'collected_published_projects',
            'total_rejected_projects',
            'goal_rejected_projects',
            'total_accepted_investments',
            'value_accepted_investments',
            'total_pending_investments',
            'value_pending_investments',
            'total_rejected_investments',
            'value_rejected_investments'
        );
    }
}
