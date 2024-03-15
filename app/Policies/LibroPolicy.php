<?php

namespace App\Policies;

use App\Models\Libro;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LibroPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Libro $libro)
    {

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {

    }
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Libro $libro)
    {
        if($user->roles->contains('slug', 'trabajador') && $user->permissions()->contains('slug', 'update-libro')){
            return true;
        }
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
        if($user->roles->contains('slug', 'trabajador') && $user->permissions()->contains('slug', 'delete-libro')){
            return true;
        }
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
