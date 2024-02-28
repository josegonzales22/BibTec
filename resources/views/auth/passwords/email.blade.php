<!DOCTYPE html>
<html lang="es">
<head>
    @include('layouts.head-login')
    <title>Registro | BibTec</title>
</head>
<body>
    <div class="container formulario">
        <div class="row">
            <div class="row" style="width: auto; margin: auto auto;">
                <div class="card">
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h5 class="card-title"><b>Enviar enlace</b></h5>
                        <p class="card-text">Ingrese su email registrado para enviarle un enlace de recuperación</p>
                        <label for="email" class="col-form-label">{{ __('Email') }}</label>
                        <form method="POST" action="{{ route('password.email') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="ejemplo@example.com">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="col-12 text-center mt-3">
                                <button type="submit" class="btn btn-a">{{ __('Enviar') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
