<?php

namespace App\Policies;

use App\Models\Prestamo;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PrestamosPolicy
{
    public function create(User $user){
        $allowedRoles = ['trabajador', 'profesor'];
        $requiredPermissions = ['create-prestamo'];

        $hasAllowedRole = $user->roles()->contains(function ($role) use ($allowedRoles){
            return in_array($role->slug, $allowedRoles);
        });

        $hasRequiredPermissions = $user->permissions()->contains(function ($permission) use ($requiredPermissions){
            return in_array($permission->slug, $requiredPermissions);
        });

        return $hasAllowedRole && $hasRequiredPermissions;
    }
    public function read(User $user) {
        $allowedRoles = ['admin', 'trabajador', 'profesor'];
        $requiredPermissions = ['read-prestamo'];

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
