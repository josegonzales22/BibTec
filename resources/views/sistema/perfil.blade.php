<x-layouts.system
title2="Perfil"
iname="Perfil">
<style>.d-icons{font-size:40px;color:whitesmoke;}</style>
<main class="container-fluid">
    <div class="card shadow ">
        <div class="card-body">
            @if(session('status'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="row justify-content-center">
                <div class="col-auto">
                    <dotlottie-player src="https://lottie.host/d2c8dd45-ee47-4206-b9e8-77f3adf0088b/W3wYB4mjzq.json"
                    background="transparent" speed="1" style="width: 150px; height: 150px;" loop autoplay></dotlottie-player>
                </div>
            </div>
            <form action="{{ route('usuario.perfil.save') }}" method="post">
                @csrf
                <input type="hidden" name="idUser" value="{{Auth::user()->id}}">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <label for="nombres">Nombres</label>
                        <input type="text" class="form-control @error('nombres') is-invalid @enderror"
                        id="nombres" name="nombres" value="{{$usuario->nombres}}" required>
                        @error('nombres')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <label for="apellidos">Apellidos</label>
                        <input type="text" class="form-control @error('apellidos') is-invalid @enderror"
                        id="apellidos" name="apellidos" value="{{$usuario->apellidos}}" required>
                        @error('apellidos')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <label for="dni">Dni</label>
                        <input type="number" class="form-control @error('dni') is-invalid @enderror"
                        id="dni" name="dni" value="{{$usuario->dni}}" required>
                        @error('dni')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <label for="email">Email</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror"
                        id="email" name="email" value="{{$usuario->email}}" required>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <br>
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <button type="submit" class="btn btn-a">Actualizar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
</x-layouts.system>
