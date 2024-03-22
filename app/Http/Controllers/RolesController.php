<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request){
        $busqueda = $request->busquedaInput;
        $roles = Role::with('permissions')
        ->where(function($query) use ($busqueda) {
            $query->where('name', 'LIKE', '%'.$busqueda.'%')
                ->orWhere('slug', 'LIKE', '%'.$busqueda.'%');
        })
        ->orderBy('id', 'desc')
        ->paginate(5);
        return view('sistema.usuarios.rol.index', ['roles' => $roles, 'busqueda' => $busqueda]);
    }
    public function create()
    {
        return view('sistema.usuarios.rol.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'role_name' => 'required|max:255',
                'role_slug' => 'required|max:255',
                'roles_permissions' => 'required',
            ]);

            $role = Role::create([
                'name' => $request->role_name,
                'slug' => $request->role_slug
            ]);
            $listOfPermissions = explode(',', $request->roles_permissions);
            DB::beginTransaction();
            foreach ($listOfPermissions as $permissionName) {
                $permission = Permission::where('name', $permissionName)->first();
                if (!$permission) {
                    $permission = Permission::create([
                        'name' => $permissionName,
                        'slug' => strtolower(str_replace(' ', '-', $permissionName))
                    ]);
                }
                if (!$role->permissions()->where('permission_id', $permission->id)->exists()) {
                    $role->permissions()->attach($permission->id);
                }
            }
            DB::commit();
            return redirect()->route('rol.index')->with('status', 'Creación de rol exitosa');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('rol.index')->with('status', $th->getMessage());
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);
        return view('sistema.usuarios.rol.show', ['role' => $role]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('sistema.usuarios.rol.edit', ['role' => $role]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        try {
            $request->validate([
                'role_name' => 'required|max:255',
                'role_slug' => 'required|max:255',
                'roles_permissions' => 'required',
            ]);

            $role = Role::findOrFail($request->rol_id);
            $role->name = $request->role_name;
            $role->slug = $request->role_slug;
            $role->save();

            $role->permissions()->detach();

            $listOfPermissions = explode(',', $request->roles_permissions);
            foreach ($listOfPermissions as $permissionName) {
                $permission = Permission::where('name', $permissionName)->first();
                if (!$permission) {
                    $permission = Permission::create([
                        'name' => $permissionName,
                        'slug' => strtolower(str_replace(' ', '-', $permissionName))
                    ]);
                }
                if (!$role->permissions()->where('permission_id', $permission->id)->exists()) {
                    $role->permissions()->attach($permission->id);
                }
            }
            return redirect()->route('rol.index')->with('status', 'Rol actualizado correctamente');
        } catch (\Throwable $th) {
            return redirect()->route('rol.index')->with('status', $th->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $role = Role::findOrFail($request->role_id);
            $role->delete();
            $role->permissions()->detach();
            return redirect()->route('rol.index')->with('status', 'Rol eliminado correctamente');
        } catch (\Throwable $th) {
            return redirect()->route('rol.index')->with('status', $th->getMessage());
        }
    }
}
