<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function store(ProjectRequest $request)
    {
        sleep(1);
        return $request->all();
    }
}
