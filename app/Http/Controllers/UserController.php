<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('index', User::class);

        $query = request()->input('query')
            ? User::search(request()->input('query'))
            : User::latest();

        return $query->paginate(request()->input('per_page', 10));
    }

    public function show(User $user)
    {
        if (request()->input('appends')) {
            $user->append(explode(',', request()->input('appends')));
        }

        return $user;
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        return tap($user)->delete();
    }

    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $data = $this->validate($request, [
            'name' => 'required',
            'password' => 'required',
            'email' => 'required|email|unique:users',
        ]);

        return User::create($data);
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $data = $this->validate($request, [
            'name' => 'required',
            'password' => 'required',
            'email' => 'email|unique:users,email,'.$user->id,
        ]);

        return tap($user)->update($data);
    }
}
