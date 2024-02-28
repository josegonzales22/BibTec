<!DOCTYPE html>
<html lang="es">
<head>
    @include('layouts.head-login')
    <title>Login | BibTec</title>
</head>
<body>
    <div class="container formulario">
        <div class="row">
            <div class="col-lg-6 col-md-12 izq bg-light">
                <div class="col-12 cont-logo">
                    <img class="logo" src="{{ asset('img/book.svg') }}" style="width:45px;">
                    <span>BibTec | Trabajador</span>
                </div>
                <div class="col-12">
                    <span class="title">Bienvenido a tu biblioteca</span><br>
                    <span class="sub-title">Hola de nuevo! Por favor completa los campos para continuar</span>
                </div>
                <div class="col-12">
                    <form action="{{route('login')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <label for="email" class="col-form-label">Email</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required
                                autocomplete="email" autofocus placeholder="ejemplo@example.com">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12 mt-2">
                                <label for="password" class="col-form-label">Contraseña</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password" placeholder="********">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12 text-end">
                                <span class="link">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('¿Olvidaste tu contraseña?') }}
                                        </a>
                                    @endif
                                </span>
                            </div>
                            <div class="col-12">
                                <br class="jump">
                                <button type="submit" class="btn btn-a">Login</button>
                                <br class="jump"><br class="jump">
                                <a href="{{ route('register') }}" class="btn btn-b">Registrar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-6 der text-center">
                <dotlottie-player class="image" src="https://lottie.host/9fbe9795-4168-4ae9-ba16-d5ae2a0b4c25/0GM0Rtkjek.json"
                background="transparent" speed="1" loop autoplay></dotlottie-player>
            </div>
        </div>
    </div>
</body>
</html>

