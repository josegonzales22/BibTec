<x-layouts.system
title2="Crear usuario"
iname="Crear usuario">
<style>.d-icons{font-size:40px;color:whitesmoke;}</style>
<main class="container-fluid">
    <div class="card shadow ">
        <div class="card-body">
            <form action="{{ route('usuario.save') }}" method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="form-group col-xl-4 col-md-4 col-lg-12">
                        <label for="dni" class="col-form-label">Documento Nacional de Identidad</label>
                        <input id="dni" type="number" class="form-control @error('dni') is-invalid @enderror" name="dni" value="{{ old('dni') }}"
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
                        value="{{ old('nombres') }}" required autocomplete="nombres" autofocus placeholder="Ej. Pedro Alejandro">
                        @error('nombres')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-xl-4 col-md-4 col-lg-12">
                        <label for="apellidos" class="col-form-label">Apellidos</label>
                        <input id="apellidos" type="text" class="form-control @error('apellidos') is-invalid @enderror" name="apellidos"
                        value="{{ old('apellidos') }}" required autocomplete="apellidos" autofocus placeholder="Suárez Mendieta">
                        @error('apellidos')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-xl-4 col-md-4 col-lg-12">
                        <label for="email" class="col-form-label">Correo</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required
                        autocomplete="email" autofocus placeholder="ejemplo@example.com">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-xl-4 col-md-4 col-lg-12">
                        <label for="password" class="col-form-label">Contraseña</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                        value="{{ old('password') }}" required autocomplete="password" autofocus placeholder="********">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-xl-4 col-md-4 col-lg-12">
                        <label for="password-confirm" class="col-form-label">Confirmar contraseña</label>
                        <input id="password-confirm" type="password" class="form-control @error('password-confirm') is-invalid @enderror" name="password_confirmation"
                        value="{{ old('password-confirm') }}" required autocomplete="new-password" autofocus placeholder="********">
                        @error('password-confirm')
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
                                <option data-role-id="{{$role->id}}" data-role-slug="{{$role->slug}}" value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-xl-4 col-md-4 col-lg-12" id="permissions_box">
                        <label for="roles">Seleccione los permisos</label>
                        <div id="permissions_checkbox_list"></div>
                    </div>
                </div>
                <div class="form-group pt-2 text-center">
                    <button type="submit" class="btn btn-a">Crear</button>
                </div>
            </form>
        </div>
    </div>
</main>
<script src="{{ asset('js/jquery/jquery.min.js') }}"></script>
<script>
    $(document).ready(function(){
    var permissions_box = $('#permissions_box'); // Corregido
    var permissions_checkbox_list = $('#permissions_checkbox_list');
    permissions_box.hide();
    $('#role').on('change', function(){
        var role=$(this).find(':selected');
        var role_id=role.data('role-id');
        var role_slug=role.data('role-slug');

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
