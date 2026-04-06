<?php

namespace App\Http\Controllers\staff;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserList extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission.check:users,view')
             ->only(['index', 'show']);

        $this->middleware('permission.check:users,create')
             ->only(['create', 'store']);

        $this->middleware('permission.check:users,edit')
             ->only(['edit', 'update']);
    }


    public function index(Request $request)
    {
        $auth = $request->user();

        // companies dropdown depends on role
        $companiesQuery = Company::query();

        if ($auth->hasRole('super_admin')) {
            // all companies
        } elseif ($auth->hasRole('admin')) {
            $companyIds = DB::table('admin_company')
                ->where('admin_user_id', $auth->id)
                ->pluck('company_id')
                ->toArray();

            $companiesQuery->whereIn('id', $companyIds);
        } elseif ($auth->hasRole('company')) {
            $companiesQuery->where('id', $auth->parent_user_id);
        } else {
            $companiesQuery->whereRaw('1=0');
        }

        $companies = $companiesQuery->orderBy('name')->get();

        // allowed roles for UI dropdown
        $allowedRoles = $this->allowedRolesFor($auth);

        return view('staff.app-user-list', compact('companies', 'allowedRoles'));
    }

    public function list(Request $request)
    {
        $auth = $request->user();

        $draw = (int) $request->input('draw', 1);
        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);
        $search = (string) $request->input('search.value', '');

        // Ordering (DataTables)
        $orderColumnIndex = (int) data_get($request->input('order'), '0.column', 0);
        $orderDir = data_get($request->input('order'), '0.dir', 'desc') === 'asc' ? 'asc' : 'desc';

        // Map DataTables index -> DB column
        // columns: id, checkbox(id), full_name(name), role, billing, status, action
        $orderable = [
            0 => 'users.id',
            2 => 'users.first_name',
            4 => 'users.status',
        ];
        $orderBy = $orderable[$orderColumnIndex] ?? 'users.created_at';

        // Base query (scope by role)
        $base = \App\Models\User::query()->select('users.*');

        if ($auth->hasRole('super_admin')) {
            // no scope
            $base->role('admin');
        } elseif ($auth->hasRole('admin')) {
            // $companyIds = DB::table('admin_company')
            //     ->where('admin_user_id', $auth->id)
            //     ->pluck('company_id')
            //     ->toArray();

            // $base->whereIn('company_id', $companyIds);
            $base->role('admin');
        } elseif ($auth->hasRole('company')) {
            // $base->where('company_id', $auth->company_id);
            $base->role('staff');
        } elseif ($auth->hasRole('staff')) {
            $base->where('id', $auth->id);
        } else {
            $base->whereRaw('1=0');
        }

        // recordsTotal (before search)
        $recordsTotal = (clone $base)->count();

        // Apply search
        if ($search !== '') {
            $base->where(function ($q) use ($search) {
                $q->where('fname', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // recordsFiltered (after search)
        $recordsFiltered = (clone $base)->count();

        if ($length === -1) {
            $length = $recordsFiltered;
        }

        // Fetch page
        $users = $base->orderBy($orderBy, $orderDir)
            ->skip($start)
            ->take($length)
            ->get();

        // Build OBJECT rows for DataTables
        // $data = $users->map(function ($u) {
        $data = $users->map(function ($u) use ($auth) {


            // correct route param name: {user}
            $viewUrl = route('app-user-view-account', $u->id);

            // Action buttons (Edit opens offcanvas)
            $buttons = '';

            if ($auth->can('super.users.delete')) {
                $buttons .= '<button type="button" title="Delete" class="btn btn-sm btn-icon delete-record" data-id="' . $u->id . '"><i class="icon-base bx bx-trash  icon-22px"></i></button>';
            }

            if ($auth->can('super.users.edit')) {
                $buttons .= '<button type="button" title="Edit" class="btn btn-sm btn-icon edit-record" data-id="' . $u->id . '" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser"><i class="icon-base bx bx-edit icon-22px"></i></button>';
            }

            $buttons .= '<button class="btn btn-sm btn-icon user-permission-modal" title="Permissions" data-user-id="' . $u->id . '" data-bs-toggle="modal" data-bs-target="#addRoleModal"><i class="icon-base bx bx-universal-access icon-24px"></i></button>';

            $actionHtml = '<div class="d-flex align-items-center gap-1">' . $buttons . '</div>';

            /* $actionHtml = '
            <div class="d-flex align-items-center gap-1">
                <button type="button" title="Delete" class="btn btn-sm btn-icon delete-record" data-id="' . $u->id . '">
                    <i class="icon-base bx bx-trash icon-22px"></i>
                </button>
                <button type="button" title="Edit" class="btn btn-sm btn-icon edit-record" data-id="' . $u->id . '" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser">
                    <i class="icon-base bx bx-edit icon-22px"></i>
                </button>
                <button class="btn btn-sm btn-icon user-permission-modal" title="Permissions" data-user-id="' . $u->id . '" data-bs-toggle="modal" data-bs-target="#addRoleModal"><i class="icon-base bx bx-universal-access icon-24px"></i></button>
            </div>'; */
            // <a href="' . $viewUrl . '" class="btn btn-sm btn-icon"><i class="icon-base bx bx-show icon-22px"></i></a> // for view user

            // Role (keep raw for JS mapping)
            $role = $u->getRoleNames()->first() ?? '—';

            return [
                'id' => $u->id,
                'first_name' => $u->first_name,
                'last_name' => $u->last_name,
                'email' => $u->email,
                'avatar' => null,
                'role' => $role, // super_admin/admin/company/staff
                'role_label' => $role !== '—' ? str_replace('_', ' ', $role) : '—',
                'status' => $u->status ?? 'active',
                'action' => $actionHtml,
            ];
        })->values();

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }

    public function show($id): JsonResponse
    {
        // $auth = $request->user();
        // $this->authorizeUserScope($auth, $user);
        $user = User::find($id);

        return response()->json([
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'status' => $user->status ?? 'active',
            'role' => $user->getRoleNames()->first() ?? null,
        ]);
    }

    public function store(Request $request)
    {
        $auth = $request->user();

        $request->validate([
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role' => ['required', Rule::in($this->allowedRolesFor($auth))],
            'status' => ['required', Rule::in(['active', 'suspended'])],
        ]);

        // enforce company_id requirement
        // $role = $request->role;
        // if (in_array($role, ['company', 'staff']) && empty($request->company_id)) {
        //     return response()->json(['message' => 'company_id is required for company/staff'], 422);
        // }

        // If company user creates staff, force same company_id
        $companyId = null;
        if ($auth->hasRole('company')) {
            $companyId = auth()->id();
        }

        $user = User::create([
            'first_name' => $request->fname,
            'last_name' => $request->lname,
            'email' => $request->email,
            'status' => $request->status,
            'password' => Hash::make($request->password),
            'parent_user_id' => $companyId,
        ]);

        $user->syncRoles([$request->role]);

        return response()->json(['status' => 'created']);
    }

    public function update($id, Request $request)
    {
        $auth = $request->user();
        $user = User::find($id);
        // $this->authorizeUserScope($auth, $user);

        $request->validate([
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'role' => ['required', Rule::in($this->allowedRolesFor($auth))],
            'status' => ['required', Rule::in(['active', 'suspended'])],
        ]);

        // company user can only update staff within same company and role must stay staff
        $companyId = null;
        if ($auth->hasRole('company')) {
            $companyId = auth()->id();
        }

        $user->first_name = $request->fname;
        $user->last_name = $request->lname;
        $user->email = $request->email;
        $user->parent_user_id = $companyId;
        $user->status = $request->status;

        if (! empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        $user->syncRoles([$request->role]);

        return response()->json(['status' => 'updated']);
    }

    public function destroy(User $user, Request $request)
    {
        $auth = $request->user();
        // $this->authorizeUserScope($auth, $user);

        // prevent deleting yourself (optional)
        if ($auth->id === $user->id) {
            return response()->json(['message' => 'You cannot delete yourself'], 422);
        }

        $user->delete();

        return response()->json(['status' => 'deleted']);
    }

    public function permissions(User $user, Request $request)
    {
        $auth = $request->user();

        // scope permissions by role
        $permissionsQuery = Permission::query();

        if ($auth->hasRole('super_admin')) {
            $permissionsQuery->whereNull('owner_user_id');
        } elseif($auth->hasRole('admin')) {
            $permissionsQuery->whereNull('owner_user_id');
        } elseif ($auth->hasRole('company')) {
            $permissionsQuery->where('owner_user_id', $auth->id);
        } else {
            abort(403);
        }

        $permissions = $permissionsQuery->orderBy('name')->get();

        // group by module (users.view → users)
        /* $grouped = $permissions->groupBy(function ($p) {
            return explode('.', $p->name)[0];
        })->map(function ($items) {
            return $items->map(fn ($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'action' => explode('.', $p->name)[1] ?? $p->name,
            ])->values();
        }); */
        $grouped = $permissions
        ->map(function ($p) {
            [$scope, $module, $action] = explode('.', $p->name, 3);

            return [
                'id'     => $p->id,
                'module' => $module,
                'action' => $action,
            ];
        })
        ->groupBy('module')
        ->map(function ($items) {
            return $items->map(fn ($p) => [
                'id'     => $p['id'],
                'action' => $p['action'],
            ])->values();
        });

        return response()->json([
            'permissions' => $grouped,
            'assigned' => $user->permissions->pluck('id')->toArray(),
        ]);
    }

    public function syncPermissions(User $user, Request $request)
    {
        $auth = $request->user();

        if (! $auth->hasAnyRole(['super_admin', 'admin', 'company'])) {
            abort(403);
        }

        $request->validate([
            'permissions' => ['array'],
            'permissions.*' => ['integer', 'exists:permissions,id'],
        ]);

        $permissionIds = $request->input('permissions', []);

        // validate ownership
        $allowedPermissionIds = Permission::query()
            ->when($auth->hasRole('super_admin'), fn ($q) => $q->whereNull('owner_user_id'))
            ->when($auth->hasRole('admin'), fn ($q) => $q->whereNull('owner_user_id'))
            ->when($auth->hasRole('company'), fn ($q) => $q->where('owner_user_id', $auth->id))
            ->pluck('id')
            ->toArray();

        $permissionIds = array_intersect($permissionIds, $allowedPermissionIds);
        $permissions = Permission::whereIn('id', $permissionIds)->get();

        $user->syncPermissions($permissions);

        return response()->json(['status' => 'permissions_updated']);
    }

    public function viewUser(Request $request, User $user)
    {
        $auth = $request->user();

        $this->authorizeUserScope($auth, $user);

        // Load relations if you have them
        $user->loadMissing(['roles', 'company']);

        return view('content.apps.app-user-view-account', [
            'viewUser' => $user,      // name it differently so it doesn't conflict with auth user
            'authUser' => $auth,
        ]);
    }

    private function allowedRolesFor($auth): array
    {
        if ($auth->hasRole('super_admin')) {
            return ['admin', 'company', 'staff'];
        }
        if ($auth->hasRole('admin')) {
            return ['company', 'staff'];
        }
        if ($auth->hasRole('company')) {
            return ['staff'];
        }

        return [];
    }

    private function authorizeUserScope($auth, User $target): void
    {
        if ($auth->hasRole('super_admin')) {
            return;
        }

        if ($auth->hasRole('company')) {
            abort_unless($target->company_id === $auth->company_id, 403);
            abort_unless($target->hasRole('staff') || $target->id === $auth->id, 403);

            return;
        }

        if ($auth->hasRole('staff')) {
            abort_unless($target->id === $auth->id, 403);

            return;
        }

        if ($auth->hasRole('admin')) {
            $companyIds = DB::table('admin_company')
                ->where('admin_user_id', $auth->id)
                ->pluck('company_id')
                ->toArray();

            abort_unless(in_array($target->company_id, $companyIds), 403);

            return;
        }

        abort(403);
    }
}
