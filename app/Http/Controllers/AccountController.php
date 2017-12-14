<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AccountController extends Controller
{
    protected $fillable = ['name', 'email', 'avatar'];

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return request()->user();
        }

        $user = auth()->user();
        $projects = $user->projects()->simplePaginate(3);
        $investments = $user->investments()->get();

        return view('account')->with(compact('user', 'projects', 'investments'));
    }

    public function edit()
    {
        return view('account.edit', [
            'user' => auth()->user()
        ]);
    }

    public function showPasswordForm()
    {
        return view('account.password', [
            'user' => auth()->user()
        ]);
    }

    public function password(Request $request)
    {
        $user = auth()->user();

        $this->validate($request, [
            'old_password' => 'required|old_password:' . $user->password,
            'password' => 'min:8|required|confirmed',
        ]);

        return tap($user)->update(['password' => bcrypt($request->get('password'))]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $this->validate($request, [
            'name' => 'required',
            'email' => 'email|unique:users,email,'.$user->id,
            'phone' => 'nullable',
            'organization' => 'nullable',
            'residence' => 'nullable',
        ]);

        return tap($user)->update($data);
    }
}
