<?php

class RoleHelper
{
    public static function creatableRoles($user)
    {
        if ($user->hasRole('super_admin')) {
            return ['super_admin', 'admin', 'company', 'staff'];
        }

        if ($user->hasRole('admin')) {
            return ['company', 'staff'];
        }

        if ($user->hasRole('company')) {
            return ['staff'];
        }

        return [];
    }
}
