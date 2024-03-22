<?php

namespace App\Policies;

use App\Models\User;

class HistorialPolicy
{
    public function read(User $user){
        $allowedRoles = ['admin', 'trabajador', 'profesor'];
        $requiredPermissions = ['read-historial'];

        $hasAllowedRole = $user->roles()->contains(function ($role) use ($allowedRoles){
            return in_array($role->slug, $allowedRoles);
        });

        $hasRequiredPermissions = $user->permissions()->contains(function ($permission) use ($requiredPermissions){
            return in_array($permission->slug, $requiredPermissions);
        });

        return $hasAllowedRole && $hasRequiredPermissions;
    }
}
