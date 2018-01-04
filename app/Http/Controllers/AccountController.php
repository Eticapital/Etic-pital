<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function showActivationForm($email, $token)
    {
        $user = User::whereEmail($email)->whereActivationToken($token)->firstOrFail();
        return view('account.activate', [
            'user' => $user,
            'token' => $token
        ]);
    }

    public function activate(Request $request, $email, $token)
    {
        $user = User::whereEmail($email)->whereActivationToken($token)->firstOrFail();

        $this->validate($request, [
            'password' => 'min:8|required|confirmed'
        ]);

        $user->password = bcrypt($request->input('password'));
        $user->activation_token = null;
        flash('¡Tu cuenta fue activada correctamente! Podrás ingresar en adelante con tu correo y la contraseña elegida.');

        $user->save();
        Auth::login($user);
        return $user;
    }
}
