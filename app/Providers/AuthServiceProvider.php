<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Libro' => 'App\Policies\LibroPolicy',
        'App\Models\Prestamo' => 'App\Policies\PrestamoPolicy',
        'App\Models\Devolucion' => 'App\Policies\DevolucionPolicy',
        'App\Models\Autor' => 'App\Policies\AutorPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Gate::define('isAdmin', function ($user){
            return $user->roles->first()->slug == 'admin';
        });
        Gate::define('isAdminOrTrabajador', function ($user) {
            $slugs = ['admin', 'trabajador'];
            foreach ($slugs as $slug) {
                if ($user->roles->contains('slug', $slug)) {
                    return true;
                }
            }
            return false;
        });
        Gate::define('isTrabajador', function($user){
            return $user->roles->first()->slug == 'trabajador';
        });
        Gate::define('isProfesor', function($user){
            return $user->roles->first()->slug == 'profesor';
        });
        Gate::define('isAdminOrTrabajadorOrProfesor', function ($user) {
            $slugs = ['admin', 'profesor', 'trabajador'];
            foreach ($slugs as $slug) {
                if ($user->roles->contains('slug', $slug)) {
                    return true;
                }
            }
            return false;
        });
        Gate::define('isEstudiante', function($user){
            return $user->roles->first()->slug == 'estudiante';
        });
    }
}
