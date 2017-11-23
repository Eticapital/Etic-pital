<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AccountController extends Controller
{
    protected $fillable = ['name', 'email', 'avatar'];

    public function index()
    {
        return request()->user();
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
        ]);

        return tap($user)->update($data);
    }
}
