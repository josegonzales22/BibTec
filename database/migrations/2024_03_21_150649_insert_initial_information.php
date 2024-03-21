<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*
        =======================
        CUENTA DE ADMIN
        =======================
        */
        DB::table('users')->insert([
            'dni' => '12345678',
            'nombres' => 'nombresAdmin',
            'apellidos' => 'apellidosAdmin',
            'email' => 'admin@example.com',
            'password' => Hash::make('12345678'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        /*
        =======================
        ROLES
        =======================
        */
        DB::table('roles')->insert([
            'name' => 'Admin',
            'slug' => 'admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('roles')->insert([
            'name' => 'Trabajador',
            'slug' => 'trabajador',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('roles')->insert([
            'name' => 'Profesor',
            'slug' => 'profesor',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('roles')->insert([
            'name' => 'Estudiante',
            'slug' => 'estudiante',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('roles')->insert([
            'name' => 'Espectador',
            'slug' => 'espectador',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        /*
        =======================
        PERMISOS
        =======================
        */
        //admin
        DB::table('permissions')->insert([
            'name' => 'create user',
            'slug' => 'create-user',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'read user',
            'slug' => 'read-user',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'update user',
            'slug' => 'update-user',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'delete user',
            'slug' => 'delete-user',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'crud rol',
            'slug' => 'crud-rol',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'update permissions',
            'slug' => 'update-permissions',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'read libro',
            'slug' => 'read-libro',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'read prestamo',
            'slug' => 'read-prestamo',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'read devolucion',
            'slug' => 'read-devolucion',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'read historial',
            'slug' => 'read-historial',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        //trabajador
        DB::table('permissions')->insert([
            'name' => 'create libro',
            'slug' => 'create-libro',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'update libro',
            'slug' => 'update-libro',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'delete libro',
            'slug' => 'delete-libro',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'baul',
            'slug' => 'baul',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'create prestamo',
            'slug' => 'create-prestamo',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'create devolucion',
            'slug' => 'create-devolucion',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        //estudiante
        DB::table('permissions')->insert([
            'name' => 'prestamo estudiante',
            'slug' => 'prestamo-estudiante',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'devolucion estudiante',
            'slug' => 'devolucion-estudiante',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        //espectador
        DB::table('permissions')->insert([
            'name' => 'none',
            'slug' => 'none',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        /*
        =======================
        users_roles
        =======================
        */
        DB::table('users_roles')->insert([
            'user_id' => 1,
            'role_id' => 1
        ]);
        /*
        =======================
        roles_permissions
        =======================
        */
            /*
            =======================
            admin
            =======================
            */
        //create user
        DB::table('roles_permissions')->insert([
            'role_id' => 1,
            'permission_id' => 1
        ]);
        //read user
        DB::table('roles_permissions')->insert([
            'role_id' => 1,
            'permission_id' => 2
        ]);
        //update user
        DB::table('roles_permissions')->insert([
            'role_id' => 1,
            'permission_id' => 3
        ]);
        //delete user
        DB::table('roles_permissions')->insert([
            'role_id' => 1,
            'permission_id' => 4
        ]);
        //crud rol
        DB::table('roles_permissions')->insert([
            'role_id' => 1,
            'permission_id' => 5
        ]);
        //update permissions
        DB::table('roles_permissions')->insert([
            'role_id' => 1,
            'permission_id' => 6
        ]);
        //read libro
        DB::table('roles_permissions')->insert([
            'role_id' => 1,
            'permission_id' => 7
        ]);
        //read prestamo
        DB::table('roles_permissions')->insert([
            'role_id' => 1,
            'permission_id' => 8
        ]);
        //read devolucion
        DB::table('roles_permissions')->insert([
            'role_id' => 1,
            'permission_id' => 9
        ]);
        //read historial
        DB::table('roles_permissions')->insert([
            'role_id' => 1,
            'permission_id' => 10
        ]);
            /*
            =======================
            trabajador
            =======================
            */
        //create libro
        DB::table('roles_permissions')->insert([
            'role_id' => 2,
            'permission_id' => 11
        ]);
        //update libro
        DB::table('roles_permissions')->insert([
            'role_id' => 2,
            'permission_id' => 12
        ]);
        //delete libro
        DB::table('roles_permissions')->insert([
            'role_id' => 2,
            'permission_id' => 13
        ]);
        //baul
        DB::table('roles_permissions')->insert([
            'role_id' => 2,
            'permission_id' => 14
        ]);
        //create prestamo
        DB::table('roles_permissions')->insert([
            'role_id' => 2,
            'permission_id' => 15
        ]);
        //create devolucion
        DB::table('roles_permissions')->insert([
            'role_id' => 2,
            'permission_id' => 16
        ]);
        //read libro
        DB::table('roles_permissions')->insert([
            'role_id' => 2,
            'permission_id' => 7
        ]);
        //read prestamo
        DB::table('roles_permissions')->insert([
            'role_id' => 2,
            'permission_id' => 8
        ]);
        //read devolucion
        DB::table('roles_permissions')->insert([
            'role_id' => 2,
            'permission_id' => 9
        ]);
        //read historial
        DB::table('roles_permissions')->insert([
            'role_id' => 2,
            'permission_id' => 10
        ]);

            /*
            =======================
            profesor
            =======================
            */
        //read libro
        DB::table('roles_permissions')->insert([
            'role_id' => 3,
            'permission_id' => 7
        ]);
        //read prestamo
        DB::table('roles_permissions')->insert([
            'role_id' => 3,
            'permission_id' => 8
        ]);
        //read devolucion
        DB::table('roles_permissions')->insert([
            'role_id' => 3,
            'permission_id' => 9
        ]);
        //read historial
        DB::table('roles_permissions')->insert([
            'role_id' => 3,
            'permission_id' => 10
        ]);
        //baul
        DB::table('roles_permissions')->insert([
            'role_id' => 3,
            'permission_id' => 14
        ]);
        //create prestamo
        DB::table('roles_permissions')->insert([
            'role_id' => 3,
            'permission_id' => 15
        ]);
        //create devolucion
        DB::table('roles_permissions')->insert([
            'role_id' => 3,
            'permission_id' => 16
        ]);
            /*
            =======================
            estudiante
            =======================
            */
        //prestamo estudiante
        DB::table('roles_permissions')->insert([
            'role_id' => 4,
            'permission_id' => 17
        ]);
        //devolución estudiante
        DB::table('roles_permissions')->insert([
            'role_id' => 4,
            'permission_id' => 18
        ]);
            /*
            =======================
            espectador
            =======================
            */
        //devolución estudiante
        DB::table('roles_permissions')->insert([
            'role_id' => 5,
            'permission_id' => 19
        ]);
        /*
        =======================
        users_permissions
        =======================
        */
        //create user
        DB::table('users_permissions')->insert([
            'user_id' => 1,
            'permission_id' => 1
        ]);
        //read user
        DB::table('users_permissions')->insert([
            'user_id' => 1,
            'permission_id' => 2
        ]);
        //update user
        DB::table('users_permissions')->insert([
            'user_id' => 1,
            'permission_id' => 3
        ]);
        //delete user
        DB::table('users_permissions')->insert([
            'user_id' => 1,
            'permission_id' => 4
        ]);
        //crud rol
        DB::table('users_permissions')->insert([
            'user_id' => 1,
            'permission_id' => 5
        ]);
        //update permissions
        DB::table('users_permissions')->insert([
            'user_id' => 1,
            'permission_id' => 6
        ]);
        //read libro
        DB::table('users_permissions')->insert([
            'user_id' => 1,
            'permission_id' => 7
        ]);
        //read prestamo
        DB::table('users_permissions')->insert([
            'user_id' => 1,
            'permission_id' => 8
        ]);
        //read devolucion
        DB::table('users_permissions')->insert([
            'user_id' => 1,
            'permission_id' => 9
        ]);
        //read historial
        DB::table('users_permissions')->insert([
            'user_id' => 1,
            'permission_id' => 10
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
