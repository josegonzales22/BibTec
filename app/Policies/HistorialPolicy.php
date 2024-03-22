<?php

namespace App\Policies;

use App\Models\User;

class HistorialPolicy
{
    public function read(User $user){
        $allowedRoles = ['admin', 'trabajador', 'profesor'];
        $requiredPermissions = ['read-historial'];

        $roles = $user->roles()->pluck('slug')->toArray();
        $permissions = $user->permissions()->pluck('slug')->toArray();

        $hasAllowedRole = !empty(array_intersect($roles, $allowedRoles));
        $hasRequiredPermissions = !empty(array_intersect($permissions, $requiredPermissions));

        return $hasAllowedRole && $hasRequiredPermissions;
    }
}
