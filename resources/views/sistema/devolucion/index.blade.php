<x-layouts.system
title2="Devolucion"
iname="Devolucion">
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
            @if (app(App\Http\Controllers\DevolucionController::class)->checkTableDevolucionIsNotEmpty())
                <div class="input-group md-form form-sm form-2 pl-0">
                    <form action="{{ route('devolucion.index') }}" method="post" class="form-inline col-12 p-0">
                        @csrf
                        <div class="input-group w-100">
                            <input class="form-control my-0 py-1 red-border" type="text" name="busquedaInput" placeholder="Buscar devolución" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-sm btn-a" type="submit">
                                    <i class="fas fa-search" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive mt-3" style="overflow-y:auto;height:50vh;">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr class="font-weight-bold text-dark">
                                <th scope="col">Estudiante</th>
                                <th scope="col">Libro</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Fecha P.</th>
                                <th scope="col">Fecha D.</th>
                            </tr>
                        </thead>
                        <tbody class="fw-light text-secondary">
                            @foreach ($devoluciones as $devolucion)
                                <tr>
                                    <td>{{$devolucion->estudiante}}</td>
                                    <td>{{$devolucion->titulo}}</td>
                                    <td>{{$devolucion->cantidad}}</td>
                                    <td>{{$devolucion->f_prestamo}}</td>
                                    <td>{{$devolucion->f_devolucion}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-12 text-right mt-2">
                    <div class="d-flex justify-content-end">
                        {{$devoluciones->appends(['busquedaInput' => $busqueda])->onEachSide(1)->render('pagination::bootstrap-5')}}
                    </div>
                </div>
            @else
                <x-layouts.empty/>
            @endif
            <div class="col-12 text-right mt-2">
                <a href="{{ route('devolucion.baul.index') }}" class="btn btn-a">
                    {{app(App\Http\Controllers\DevolucionController::class)->verCantBaulPres(Auth::user()->id)}}
                    <i class="fa-solid fa-box-archive"></i>
                </a>
                <a href="{{ route('devolucion.escaner') }}" class="btn btn-a">
                    <i class="fa-solid fa-qrcode"></i> Escáner
                </a>
            </div>
        </div>
    </div>
</main>
</x-layouts.system>
