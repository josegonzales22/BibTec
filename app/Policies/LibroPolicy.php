<?php

namespace App\Policies;

use App\Models\Libro;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LibroPolicy
{
    public function update(User $user, Libro $libro)
    {
        return $user->roles->contains(function ($role) {
            return $role->slug === 'trabajador';
        }) && $user->permissions->contains(function ($permission) {
            return $permission->slug === 'update-libro';
        });
        return false;
    }
    public function updateAutor(User $user)
    {
        return $user->roles->contains(function ($role) {
            return $role->slug === 'trabajador';
        }) && $user->permissions->contains(function ($permission) {
            return $permission->slug === 'update-libro';
        });
        return false;
    }
    public function checkUpdate(User $user){
        return $user->roles->contains(function ($role) {
            return $role->slug === 'trabajador';
        }) && $user->permissions->contains(function ($permission) {
            return $permission->slug === 'update-libro';
        });
    }
    public function checkRead(User $user){
        return ($user->roles->contains('slug', 'admin') && $user->permissions->contains('slug', 'read-libros')
        || $user->roles->contains('slug', 'trabajador') && $user->permissions->contains('slug', 'read-libro') );
    }
    public function checkDelete(User $user){
        return $user->roles->contains(function ($role) {
            return $role->slug === 'trabajador';
        }) && $user->permissions->contains(function ($permission) {
            return $permission->slug === 'delete-libro';
        });
    }
    public function checkAddToBaul(User $user){
        return $user->roles->contains(function ($role) {
            return $role->slug === 'trabajador';
        }) && $user->permissions->contains(function ($permission) {
            return $permission->slug === 'add-to-baul';
        });
    }
    public function checkAddToPlantilla(User $user){
        return $user->roles->contains(function ($role) {
            return $role->slug === 'trabajador';
        }) && $user->permissions->contains(function ($permission) {
            return $permission->slug === 'add-to-plantilla';
        });
    }
    public function checkCreateLibro(User $user){
        return $user->roles->contains(function ($role) {
            return $role->slug === 'trabajador';
        }) && $user->permissions->contains(function ($permission) {
            return $permission->slug === 'create-libro';
        });
    }
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user)
    {
        return $user->roles->contains(function ($role) {
            return $role->slug === 'trabajador';
        }) && $user->permissions->contains(function ($permission) {
            return $permission->slug === 'delete-libro';
        });
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Libro $libro)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Libro $libro)
    {
        //
    }
}
