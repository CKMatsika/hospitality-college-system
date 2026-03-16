<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleManagementController extends Controller
{
    /**
     * Display a listing of users with their roles.
     */
    public function users()
    {
        $users = User::with('roles')->paginate(15);
        $roles = Role::all();
        
        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Update user roles.
     */
    public function updateUserRoles(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'array',
            'roles.*' => 'exists:roles,name',
        ]);

        $user->syncRoles($request->roles);

        return back()->with('success', 'User roles updated successfully.');
    }

    /**
     * Display roles listing.
     */
    public function roles()
    {
        $roles = Role::with('permissions')->paginate(15);
        $permissions = Permission::all()->groupBy(function($permission) {
            return explode('.', $permission->name)[0];
        });

        return view('admin.roles.index', compact('roles', 'permissions'));
    }

    /**
     * Store a new role.
     */
    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->givePermissionTo($request->permissions);

        return back()->with('success', 'Role created successfully.');
    }

    /**
     * Update role permissions.
     */
    public function updateRole(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role->syncPermissions($request->permissions);

        return back()->with('success', 'Role permissions updated successfully.');
    }

    /**
     * Remove the specified role.
     */
    public function destroyRole(Role $role)
    {
        if ($role->name === 'super-admin') {
            return back()->with('error', 'Cannot delete super-admin role.');
        }

        $role->delete();

        return back()->with('success', 'Role deleted successfully.');
    }

    /**
     * Display permissions listing.
     */
    public function permissions()
    {
        $permissions = Permission::all()->groupBy(function($permission) {
            return explode('.', $permission->name)[0];
        });

        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Store a new permission.
     */
    public function storePermission(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name',
        ]);

        Permission::create(['name' => $request->name]);

        return back()->with('success', 'Permission created successfully.');
    }

    /**
     * Remove the specified permission.
     */
    public function destroyPermission(Permission $permission)
    {
        $permission->delete();

        return back()->with('success', 'Permission deleted successfully.');
    }
}
