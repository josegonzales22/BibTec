<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request){
        $busqueda = $request->busquedaInput;
        $usuarios = User::where(function($query) use ($busqueda) {
            $query->where('dni', 'LIKE', '%'.$busqueda.'%')
                ->orWhere('nombres', 'LIKE', '%'.$busqueda.'%')
                ->orWhere('apellidos', 'LIKE', '%'.$busqueda.'%')
                ->orWhere('email', 'LIKE', '%'.$busqueda.'%')
                ->orWhere('created_at', 'LIKE', '%'.$busqueda.'%')
                ->orWhere('updated_at', 'LIKE', '%'.$busqueda.'%');
        })
        ->groupBy('id')
        ->orderByDesc('id')
        ->paginate(5);
        return view('sistema.usuarios.index', ['usuarios' => $usuarios, 'busqueda' => $busqueda]);
    }
    public function indexPerfil($id){
        $usuario = User::findOrFail($id);
        return view('sistema.perfil', ['usuario' => $usuario]);
    }
    public function updatePerfil(Request $request){
        $validator = $request->validate([
            'idUser' => ['required','numeric'],
            'dni' => ['required','numeric','digits:8'],
            'nombres' => ['required','string','max:50'],
            'apellidos' => ['required','string','max:50'],
            'email' => ['required','max:255','email'],
        ]);

        try {
            $user = User::findOrFail($request->idUser);
            $user->nombres = $request->nombres;
            $user->apellidos = $request->apellidos;
            $user->dni = $request->dni;
            $user->email = $request->email;
            $user->save();
            return redirect()->route('usuario.perfil', ['id'=>Auth::user()->id])->with('status', 'Usuario actualizado correctamente');
        } catch (\Throwable $th) {
            return redirect()->route('usuario.perfil', ['id'=>Auth::user()->id])->with('status', $th->getMessage());
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if($request->ajax()){
            $roles = Role::where('id', $request->role_id)->first();
            $permissions = $roles->permissions;
            return $permissions;
        }
        $roles = Role::all();
        return view('sistema.usuarios.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveUserRequest $request)
    {

        try {
            $user = User::create([
                'dni' => $request->input('dni'),
                'nombres' => $request->input('nombres'),
                'apellidos' => $request->input('apellidos'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password'))
            ]);

            if ($request->role != null) {
                $user->roles()->attach($request->role);
                $user->save();
            }

            if ($request->permissions != null) {
                foreach ($request->permissions as $permissionId) {
                    if (!$user->permissions()->where('permission_id', $permissionId)->exists()) {
                        $user->permissions()->attach($permissionId);
                        $user->save();
                    }
                }
            }

            return redirect()->route('usuario.index')->with('status', 'Usuario creado correctamente');
        } catch (\Throwable $th) {
            return redirect()->route('usuario.index')->with('status', $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id){
        $user = User::findOrFail($id);
        $roles = Role::get();
        $userRole = $user->roles->first();
        $rolePermissions = $userRole ? $userRole->permissions : [];
        $userPermissions = $user->permissions;

        return view('sistema.usuarios.edit', [
            'user' => $user,
            'roles' => $roles,
            'userRole' => $userRole,
            'rolePermissions' => $rolePermissions,
            'userPermissions' => $userPermissions
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
{
    try {
        $request->validate([
            'dni' => 'required|max:255',
            'nombres' => 'required|max:50',
            'apellidos' => 'required|max:50',
            'email' => 'required|max:255|email',
        ]);

        $user->dni = $request->dni;
        $user->nombres = $request->nombres;
        $user->apellidos = $request->apellidos;
        $user->email = $request->email;

        // Verificar si se enviaron datos de roles y permisos
        if ($request->has('role')) {
            $user->roles()->sync($request->role); // Adjuntar roles
        }

        if ($request->has('permissions')) {
            $user->permissions()->sync($request->permissions); // Adjuntar permisos
        }

        // Solo guardar si se realizaron cambios en los roles o permisos
        if ($request->has('role') || $request->has('permissions')) {
            $user->save();
        }

        return redirect()->route('usuario.index')->with('status', 'Usuario modificado correctamente');
    } catch (\Throwable $th) {
        return redirect()->route('usuario.index')->with('status', $th->getMessage());
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            if($id==Auth::user()->id){
                return redirect()->route('usuario.index')->with('status', 'El usuario logueado no puede ser eliminado');
            }else{
                $user = User::findOrFail($id);
                $user->roles()->detach();
                $user->permissions()->detach();
                $user->delete();
                return redirect()->route('usuario.index')->with('status', 'Usuario eliminado correctamente');
            }
        } catch (\Throwable $th) {
            return redirect()->route('usuario.index')->with('status', $th->getMessage());
        }
    }
}
