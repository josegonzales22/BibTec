<?php

namespace App\Policies;
use App\Models\User;

class LibroPolicy
{
    public function create(User $user){
        return $user->roles->contains(function ($role) {
            return $role->slug === 'trabajador';
        }) && $user->permissions->contains(function ($permission) {
            return $permission->slug === 'create-libro';
        });
        return false;
    }
    public function read(User $user){
        $allowedRoles = ['admin', 'trabajador', 'profesor'];
        $requiredPermissions = ['read-libro'];

        $userRoles = $user->roles()->pluck('slug')->toArray();
        $userPermissions = $user->permissions()->pluck('slug')->toArray();

        $hasAllowedRole = count(array_intersect($userRoles, $allowedRoles)) > 0;
        $hasRequiredPermissions = count(array_intersect($userPermissions, $requiredPermissions)) > 0;

        return $hasAllowedRole && $hasRequiredPermissions;
    }
    public function update(User $user){
        return $user->roles->contains(function ($role) {
            return $role->slug === 'trabajador';
        }) && $user->permissions->contains(function ($permission) {
            return $permission->slug === 'update-libro';
        });
        return false;
    }
    public function delete(User $user){
        return $user->roles->contains(function ($role) {
            return $role->slug === 'trabajador';
        }) && $user->permissions->contains(function ($permission) {
            return $permission->slug === 'delete-libro';
        });
        return false;
    }
    public function baul(User $user){
        return $user->permissions->contains(function ($permission) {
            return $permission->slug === 'baul';
        });
    }
}
