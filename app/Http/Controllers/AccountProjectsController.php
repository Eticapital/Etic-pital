<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountProjectsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $projects = $user->projects()->paginate(10);
        return view('account.projects')->with(compact('user', 'projects'));
    }
}
