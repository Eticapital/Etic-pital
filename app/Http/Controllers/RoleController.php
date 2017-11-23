<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Muestra la lista de roles en el sistema
     *
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('index', Role::class);

        $query = request()->input('query')
            ? Role::search(request()->input('query'))
            : Role::latest()->filterByDataTable(request());

        return $query->paginate(request()->input('per_page', 10));
    }

    /**
     * Devuelve el grupo buscado
     * @param  Role   $role
     *
     * @return json
     */
    public function show(Role $role)
    {
        $this->authorize('show', $role);

        return $role;
    }

    /**
     * Guarda el nuevo grupo en una base de datos
     *
     * @param  Request $request
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('store', Role::class);

        $this->validate($request, [
            'display_name' => 'required',
        ]);

        return Role::create($request->all());
    }

    /**
     * Actualiza un rol
     *
     * @param  Role    $role
     * @param  Request $request
     * @return Illuminate\Http\Response
     */
    public function update(Role $role, Request $request)
    {
        $this->authorize('update', $role);

        $this->validate($request, [
            'display_name' => 'required',
        ]);

        return tap($role)->update($request->all());
    }

    /**
     * Elimina el grupo
     *
     * @param  Role   $role
     * @return
     */
    public function destroy(Role $role)
    {
        $this->authorize('destroy', $role);

        tap($role)->delete();
    }
}
