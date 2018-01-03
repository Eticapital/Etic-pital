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

        $results = $query->paginate(request()->input('per_page', 10));

        if (request()->input('appends')) {
            return tap($results)->each(function ($user) {
                $user->lazyAppend(request()->input('appends'));
            });
        }

        return $results;
    }

    public function show(User $user)
    {
        if (request()->input('appends')) {
            $user->lazyAppend(request()->input('appends'));
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
            'password' => 'required|confirmed',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable',
            'organization' => 'nullable',
            'residence' => 'nullable',
            'roles' => 'array',
        ]);

        return tap(User::create($data), function ($user) use ($request, $data) {
            if (array_key_exists('roles', $data)) {
                $user->roles()->sync($data['roles']);
            }
            $user->is_published = boolval($request->input('is_published'));
            $user->save();
        });
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $data = $this->validate($request, [
            'name' => 'required',
            'password' => 'sometimes|nullable|confirmed',
            'email' => 'email|unique:users,email,'.$user->id,
            'phone' => 'nullable',
            'organization' => 'nullable',
            'residence' => 'nullable',
            'roles' => 'array',
        ]);

        if (!$data['password']) {
            unset($data['password']);
        }

        return tap($user, function ($user) use ($request, $data) {
            $user->update($data);
            if (array_key_exists('roles', $data)) {
                $user->roles()->sync($data['roles']);
            }
            $user->is_published = boolval($request->input('is_published'));
            $user->save();
        });
    }

    public function toggleStatus(User $user)
    {
        $this->authorize('status', $user);

        $user->is_published = !$user->is_published;
        $user->save();

        return $user;
    }
}
