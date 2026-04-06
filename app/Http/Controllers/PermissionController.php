<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /* public function __construct()
    {
        $this->middleware('auth');

        // View permissions & metadata
        $this->middleware('permission.check:permissions,view')
            ->only(['index', 'list', 'meta']);

        // Create new permissions
        $this->middleware('permission.check:permissions,create')
            ->only(['store']);

        // Update permissions
        $this->middleware('permission.check:permissions,edit')
            ->only(['update']);
    } */

    public function meta()
    {
        return response()->json([
            'modules' => config('acl.modules'),
            'actions' => config('acl.actions'),
        ]);
    }
    public function index()
    {
        return view('permissions.index');
    }

    public function list()
    {
        $user = auth()->user();

        $permissions = Permission::query()
            ->when($user->hasRole('super_admin'), function ($query) {
                $query->whereNull('owner_user_id');
            })
            ->when($user->hasRole('company'), function ($query) use ($user) {
                $query->where('owner_user_id', $user->id);
            })
            ->get()
            ->transform(function ($permission) {
                $permission->name = preg_replace('/^(super|company)\./', '', $permission->name);
                return $permission;
            });

        return response()->json(['data' => $permissions]);
    }

    /* public function store(Request $request)
    {
        $request->validate([
            'module' => ['required', Rule::in(config('acl.modules'))],
            'action' => ['required', Rule::in(config('acl.actions'))],
        ]);

        $name = "{$request->module}.{$request->action}";

        // Optional: if company should have its own permission set, add owner_user_id column
        // otherwise permissions are global.
        $permission = Permission::create([
            'name' => $name,
            'guard_name' => 'web',
            'owner_user_id' => auth()->user()->hasRole('company') ? auth()->id() : null,
        ]);

        return response()->json(['id' => $permission->id, 'name' => $permission->name]);
    } */
    public function store(Request $request)
    {
        $request->validate([
            'module' => ['required', Rule::in(config('acl.modules'))],
            'action' => ['required', Rule::in(config('acl.actions'))],
        ]);

        $auth = auth()->user();

        // 🔑 namespace prefix
        if ($auth->hasRole('company')) {
            $prefix = 'company_' . $auth->id;
        } else {
            $prefix = 'super';
        }

        $name = "{$prefix}.{$request->module}.{$request->action}";

        $permission = Permission::firstOrCreate(
            [
                'name'       => $name,
                'guard_name' => 'web',
            ],
            [
                'owner_user_id' => $auth->hasRole('company') ? $auth->id : null,
            ]
        );

        return response()->json([
            'id'   => $permission->id,
            'name' => $permission->name,
        ]);
    }


    public function update(Request $request, $id)
    {
        /* $auth = auth()->user();

        if ($auth->hasRole('company') && $permission->owner_user_id !== $auth->id) {
            abort(403);
        } */

        $request->validate([
            'module' => ['required', Rule::in(config('acl.modules'))],
            'action' => ['required', Rule::in(config('acl.actions'))],
        ]);

        $permission = Permission::findOrFail($id);
        $name = "{$request->module}.{$request->action}";

        // Unique check (ignore current)
        $exists = Permission::where('name', $name)->where('id', '!=', $permission->id)->exists();
        if ($exists) {
            return response()->json(['message' => 'Permission already exists'], 422);
        }

        $permission->update(['name' => $name]);

        return response()->json(['id' => $permission->id, 'name' => $permission->name]);
    }
}
