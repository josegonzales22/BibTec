<x-layouts.system
title2="Editar usuario"
iname="Editar usuario">
<style>.d-icons{font-size:40px;color:whitesmoke;}</style>
<main class="container-fluid">
    <div class="card shadow ">
        <div class="card-body">
            <form action="/usuarios/update/{{$user->id}}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    <div class="form-group col-xl-4 col-md-4 col-lg-12">
                        <label for="dni" class="col-form-label">Documento Nacional de Identidad</label>
                        <input id="dni" type="number" class="form-control @error('dni') is-invalid @enderror" name="dni" value="{{$user->dni}}"
                        required autocomplete="dni" autofocus placeholder="Ej. 12345678">
                        @error('dni')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-xl-4 col-md-4 col-lg-12">
                        <label for="nombres" class="col-form-label">Nombres</label>
                        <input id="nombres" type="text" class="form-control @error('nombres') is-invalid @enderror" name="nombres"
                        value="{{$user->nombres}}" required autocomplete="nombres" autofocus placeholder="Ej. Pedro Alejandro">
                        @error('nombres')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-xl-4 col-md-4 col-lg-12">
                        <label for="apellidos" class="col-form-label">Apellidos</label>
                        <input id="apellidos" type="text" class="form-control @error('apellidos') is-invalid @enderror" name="apellidos"
                        value="{{$user->apellidos}}" required autocomplete="apellidos" autofocus placeholder="Suárez Mendieta">
                        @error('apellidos')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-xl-4 col-md-4 col-lg-12">
                        <label for="email" class="col-form-label">Correo</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$user->email}}" required
                        autocomplete="email" autofocus placeholder="ejemplo@example.com">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-xl-4 col-md-4 col-lg-12">
                        <label for="password-confirm" class="col-form-label">Seleccione rol</label>
                        <select class="form-control role" name="role" id="role" required>
                            <option value="">Seleccione un rol</option>
                            @foreach ($roles as $role)
                                <option data-role-id="{{$role->id}}" data-role-slug="{{$role->slug}}" value="{{$role->id}}" {{$user->roles->isEmpty() || $role->name != $userRole->name ? "" : "selected"}}>{{$role->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-xl-4 col-md-4 col-lg-12" id="permissions_box">
                        <label for="roles">Seleccione los permisos</label>
                        <div id="permissions_checkbox_list"></div>
                    </div>
                    @if ($user->permissions->isNotEmpty())
                        @if ($rolePermissions != null)
                            <div id="user_permissions_box">
                                <label for="roles">Permisos del usuario</label>
                                <div id="user_permissions_checkbox_list">
                                    @foreach ($rolePermissions as $permission)
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="permissions[]"
                                            id="{{$permission->slug}}" value="{{$permission->id}}"
                                            {{in_array($permission->id, $userPermissions->pluck('id')->toArray() ) ?
                                            'checked="checked"': ''}}>
                                            <label for="{{$permission->slug}}" class="custom-control-label">{{$permission->name}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
                <div class="form-group pt-2 text-center">
                    <button type="submit" class="btn btn-a">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</main>
<script src="{{ asset('js/jquery/jquery.min.js') }}"></script>
<script>
    $(document).ready(function(){
    var permissions_box = $('#permissions_box');
    var permissions_checkbox_list = $('#permissions_checkbox_list');
    var user_permissions_box = $('#user_permissions_box');
    var user_permissions_checkbox_list = $('#user_permissions_checkbox_list');

    permissions_box.hide();
    $('#role').on('change', function(){
        var role=$(this).find(':selected');
        var role_id=role.data('role-id');
        var role_slug=role.data('role-slug');

        permissions_checkbox_list.empty();
        user_permissions_box.empty();

        $.ajax({
            url:'/usuarios/crear',
            method:'get',
            dataType:'json',
            data:{
                role_id:role_id,
                role_slug:role_slug,
            }
        }).done(function(data){
            console.log(data);
            permissions_box.show();
            permissions_checkbox_list.empty();
            $.each(data, function(index,element){
                permissions_checkbox_list.append(
                    '<div class="custom-control custom-checkbox">' +
                        '<input class="custom-control-input" type="checkbox" name="permissions[]" id="' + element.slug + '" value="' + element.id + '">' +
                        '<label class="custom-control-label" for="' + element.slug + '">' + element.name + '</label>' +
                    '</div>'
                );
            });
        });
    });
});
</script>
</x-layouts.system>
