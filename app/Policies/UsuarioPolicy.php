<?php

namespace App\Policies;

use App\Models\User;

class UsuarioPolicy
{
    public function create(User $user){
        return $user->roles->contains(function ($role) {
            return $role->slug === 'admin';
        }) && $user->permissions->contains(function ($permission) {
            return $permission->slug === 'create-user';
        });
        return false;
    }
    public function read(User $user){
        return $user->roles->contains(function ($role) {
            return $role->slug === 'admin';
        }) && $user->permissions->contains(function ($permission) {
            return $permission->slug === 'read-user';
        });
        return false;
    }
    public function update(User $user){
        return $user->roles->contains(function ($role) {
            return $role->slug === 'admin';
        }) && $user->permissions->contains(function ($permission) {
            return $permission->slug === 'update-user';
        });
        return false;
    }
    public function delete(User $user){
        return $user->roles->contains(function ($role) {
            return $role->slug === 'admin';
        }) && $user->permissions->contains(function ($permission) {
            return $permission->slug === 'delete-user';
        });
        return false;
    }
    public function crudRol(User $user){
        return $user->roles->contains(function ($role) {
            return $role->slug === 'admin';
        }) && $user->permissions->contains(function ($permission) {
            return $permission->slug === 'crud-rol';
        });
        return false;
    }
    public function updatePermissions(User $user){
        return $user->roles->contains(function ($role) {
            return $role->slug === 'admin';
        }) && $user->permissions->contains(function ($permission) {
            return $permission->slug === 'update-permissions';
        });
        return false;
    }
    public function prestamoEstudiante(User $user){
        return $user->roles->contains(function ($role) {
            return $role->slug === 'estudiante';
        }) && $user->permissions->contains(function ($permission) {
            return $permission->slug === 'prestamo-estudiante';
        });
        return false;
    }
    public function devolucionEstudiante(User $user){
        return $user->roles->contains(function ($role) {
            return $role->slug === 'estudiante';
        }) && $user->permissions->contains(function ($permission) {
            return $permission->slug === 'devolucion-estudiante';
        });
        return false;
    }
}
