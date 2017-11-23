<?php

namespace App\Http\Controllers;

use App\Models\ProjectStage;
use Illuminate\Http\Request;

class ProjectStageController extends Controller
{
    public function index()
    {
        return ProjectStage::orderBy('label')->get();
    }
}
