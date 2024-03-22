<?php

namespace App\Policies;

use App\Models\User;

class DevolucionPolicy
{
    public function create(User $user){
        $allowedRoles = ['trabajador', 'profesor'];
        $requiredPermissions = ['create-devolucion'];

        $roles = $user->roles()->pluck('slug')->toArray();
        $permissions = $user->permissions()->pluck('slug')->toArray();

        $hasAllowedRole = !empty(array_intersect($roles, $allowedRoles));
        $hasRequiredPermissions = !empty(array_intersect($permissions, $requiredPermissions));

        return $hasAllowedRole && $hasRequiredPermissions;
    }
    public function read(User $user){
        $allowedRoles = ['admin', 'trabajador', 'profesor'];
        $requiredPermissions = ['read-devolucion'];

        $roles = $user->roles()->pluck('slug')->toArray();
        $permissions = $user->permissions()->pluck('slug')->toArray();

        $hasAllowedRole = !empty(array_intersect($roles, $allowedRoles));
        $hasRequiredPermissions = !empty(array_intersect($permissions, $requiredPermissions));

        return $hasAllowedRole && $hasRequiredPermissions;
    }
    public function baul(User $user){
        return $user->permissions->contains(function ($permission) {
            return $permission->slug === 'baul';
        });
    }
}
