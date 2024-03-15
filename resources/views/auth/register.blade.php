<!DOCTYPE html>
<html lang="es">
<head>
    @include('components.layouts.head-login')
    <title>Registro | BibTec</title>
</head>
<body>
    <div class="container formulario">
        <div class="row">
            <!--
                | Primera interfaz |
             -->
            <div class="col-lg-6 col-md-12 izq bg-light" id="ui1a">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <label for="text" class="col-form-label"><b>Nuevo usuario</b></label>
                        </div>
                        <form method="POST" action="{{ route('register') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="col-12">
                            <label for="dni" class="col-form-label">Documento Nacional de Identidad</label>
                            <input id="dni" type="number" class="form-control @error('dni') is-invalid @enderror" name="dni" value="{{ old('dni') }}"
                            required autocomplete="dni" autofocus placeholder="12345678">
                            @error('dni')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="nombres" class="col-form-label">Nombres</label>
                            <input id="nombres" type="text" class="form-control @error('nombres') is-invalid @enderror" name="nombres"
                            value="{{ old('nombres') }}" required autocomplete="nombres" autofocus placeholder="Pedro Alejandro">
                            @error('nombres')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="apellidos" class="col-form-label">Apellidos</label>
                            <input id="apellidos" type="text" class="form-control @error('apellidos') is-invalid @enderror" name="apellidos"
                            value="{{ old('apellidos') }}" required autocomplete="apellidos" autofocus placeholder="Suárez Mendieta">
                            @error('apellidos')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-12" style="text-align: right">
                            <br>
                            <a href="#" class="btn btn-a" id="btn1">Continuar</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 der text-center" id="ui1b">
                <dotlottie-player class="image" src="https://lottie.host/9fbe9795-4168-4ae9-ba16-d5ae2a0b4c25/0GM0Rtkjek.json"
                background="transparent" speed="1" loop autoplay></dotlottie-player>
            </div>
            <!--
                | Segunda interfaz |
            -->
            <div class="col-lg-6 col-md-12 izq bg-light d-none" id="ui2a">
                <div class="col-12">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="row">
                        <div class="col-12">
                            <label for="text" class="col-form-label"><b>Nuevo usuario</b></label>
                        </div>
                        <div class="col-12">
                            <label for="perfil_id" class="col-form-label">Perfil</label>
                            <select name="perfil_id" id="perfil_id" class="form-select">
                                <option value="1" selected>Trabajador</option>
                                <option value="2">Estudiante</option>
                            </select>
                            @error('perfil_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="email" class="col-form-label">Correo</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required
                            autocomplete="email" autofocus placeholder="ejemplo@example.com">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="password" class="col-form-label">Contraseña</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                            value="{{ old('password') }}" required autocomplete="password" autofocus placeholder="********">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="password-confirm" class="col-form-label">Confirmar contraseña</label>
                            <input id="password-confirm" type="password" class="form-control @error('password-confirm') is-invalid @enderror" name="password_confirmation"
                            value="{{ old('password-confirm') }}" required autocomplete="new-password" autofocus placeholder="********">
                            @error('password-confirm')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-12" style="text-align: right">
                            <br class="jump">
                            <a href="#" class="btn btn-b" id="btn2">Regresar</a>
                            <br class="jump"><br class="jump">
                            <button type="submit" class="btn btn-a">Registrar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
            <div class="col-6 der text-center d-none" id="ui2b">
                <dotlottie-player class="image" src="https://lottie.host/9fbe9795-4168-4ae9-ba16-d5ae2a0b4c25/0GM0Rtkjek.json"
                background="transparent" speed="1" loop autoplay></dotlottie-player>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("btn1").addEventListener("click", function(event) {
            event.preventDefault();
            document.getElementById("ui1a").classList.add("d-none");
            document.getElementById("ui1b").classList.add("d-none");

            document.getElementById("ui2a").classList.remove("d-none");
            document.getElementById("ui2b").classList.remove("d-none");
        });
        document.getElementById("btn2").addEventListener("click", function(event) {
            event.preventDefault();
            document.getElementById("ui2a").classList.add("d-none");
            document.getElementById("ui2b").classList.add("d-none");

            document.getElementById("ui1a").classList.remove("d-none");
            document.getElementById("ui1b").classList.remove("d-none");
        });

    </script>
</body>


