<x-layouts.system
title2="Devoluciones"
iname="Devoluciones">
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
            @if (app(App\Http\Controllers\EstudianteController::class)->checkTableDevolucionIsNotEmpty())
            <div class="input-group md-form form-sm form-2 pl-0">
                <form action="{{ route('devoluciones.index.estudiante') }}" method="post" class="form-inline col-12 p-0">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
                            <th scope="col">Libro</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">F. Préstamo</th>
                            <th scope="col">F. Devolución</th>
                        </tr>
                    </thead>
                    <tbody class="fw-light text-secondary">
                        @foreach ($devoluciones as $devolucion)
                            <tr>
                                <td>{{$devolucion->titulo}}</td>
                                <td>{{$devolucion->cantidad}}</td>
                                <td>{{$devolucion->f_prestamo}}</td>
                                <td>{{$devolucion->f_devolucion}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-12 mb-3 " style="text-align: right; margin-left: 12px;">
            <div class="col-12 mr-4">
                <div class="d-flex justify-content-end">
                    {{ $devoluciones->appends(['busquedaInput' => $busqueda])->onEachSide(1)->render('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
        @else
            <x-layouts.empty/>
        @endif
    </div>
</main>
</x-layouts.system>
