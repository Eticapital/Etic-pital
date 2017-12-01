<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Muestra la página de inicio
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::featuredFirst()
            ->published()
            ->limit(6)
            ->get();

        return view('home')->with(compact('projects'));
    }
}
