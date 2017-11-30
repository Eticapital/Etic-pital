<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        dd(\App\Models\Project::all()->toArray());
        return view('admin');
    }
}
