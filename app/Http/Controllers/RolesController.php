<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users')->get();
        $permissions = Permission::all();
        return view('roles.index', compact('roles', 'permissions'));
    }

    public function list()
    {
        return response()->json(
            Role::with('permissions')->get()
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'array'
        ]);

        $name = str_replace(' ', '_', strtolower($request->name));

        $role = Role::create([
            'name' => $name,
            'guard_name' => 'web'
        ]);

        if ($request->filled('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return response()->json([
            'success' => true,
            'message' => 'Role "' . $role->name . '" created successfully'
        ]);
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        // Validate the request
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'permissions' => 'array'
        ]);

        // Update role name
        $name = str_replace(' ', '_', strtolower($request->name));
        $role->name = $name;
        $role->save();

        // Sync permissions
        if ($request->filled('permissions')) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->syncPermissions([]); // remove all permissions if none selected
        }

        // Return JSON success response
        return response()->json([
            'success' => true,
            'message' => 'Role "' . $role->name . '" updated successfully'
        ]);
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json(['status' => 'deleted']);
    }
}
