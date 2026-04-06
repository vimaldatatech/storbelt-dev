<?php

use App\Models\User;

if (! function_exists('canAccess')) {
    function canAccess(User $user, string $module, string $action): bool
    {
        // Super admin bypass (extra safety, Gate already handles this)
        if ($user->hasRole('super_admin')) {
            return true;
        }

        // Staff: permissions are company-scoped
        if ($user->hasRole('staff')) {
            $companyId = $user->owner_user_id; // or company_id if you use that
            $permission = "company_{$companyId}.{$module}.{$action}";

            return $user->hasPermissionTo($permission);
        }

        // Admin & Company: permissions assigned by super_admin
        if ($user->hasAnyRole(['admin', 'company'])) {
            $permission = "super.{$module}.{$action}";

            return $user->hasPermissionTo($permission);
        }

        return false;
    }
}
