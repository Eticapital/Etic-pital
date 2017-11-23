<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    /**
     * Regresa los permisos que son configurables
     *
     * @return json
     */
    public function index(Role $role)
    {
        $this->authorize('permissions', $role);

        $rolePermissions = $role->permissions()->get()->map(function ($permission) {
            return $permission->name;
        });

        return response()->json([
            'acl' => config('acl'),
            'role' => $role,
            'rolePermissions' => $rolePermissions
        ]);
    }

    /**
     * Agrega o elimina un permiso a un rol
     *
     * @param  Role    $role
     * @param  Request $request
     * @param  $permission_name
     * @return json
     */
    public function toggle(Request $request, Role $role, $permission = null)
    {
        $this->authorize('permissionsToggle', $role);

        // En algunas ocasiones el permiso no se ha creado
        // para ello lo guardamos antes
        // Ver: RouteServiceProvider
        if (!($permission_model = Permission::where('name', $permission)->first())) {
            $permission = $this->createPermission($permission);
        } else {
            $permission = $permission_model;
        }

        if ($request->input('checked')) {
            if (!$role->hasPermission($permission->name)) {
                $role->attachPermission($permission);
            }
        } else {
            $role->detachPermission($permission);
        }

        return $permission;
    }

    private function createPermission($name)
    {
        $permissions = collect(config('acl.permissions'))->mapWithKeys(function ($permissions, $module) {
            if (is_array($permissions)) {
                return collect($permissions)->mapWithKeys(function ($label, $name) use ($module) {
                    return [$module . '.' . $name => $label];
                });
            } else {
                return [$module => $permissions];
            }
        });

        if (!$permissions->has($name)) {
            abort(404, 'Permiso no encontrado');
        }

        $permission = new \App\Models\Permission;
        $permission->name = $name;
        $permission->display_name = $permissions->get($name);
        return tap($permission)->save();
    }
}
