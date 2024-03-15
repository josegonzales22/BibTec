<x-layouts.system
title2="Prestamos"
iname="Prestamos">
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
            <div class="input-group md-form form-sm form-2 pl-0">
                <form action="{{ route('prestamo.index') }}" method="post" class="form-inline col-12 p-0">
                    @csrf
                    <div class="input-group w-100">
                        <input class="form-control my-0 py-1 red-border" type="text" name="busquedaInput" placeholder="Buscar préstamo" aria-label="Search">
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
                            <th scope="col">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="fw-light text-secondary">
                        @foreach ($prestamos as $prestamo)
                            <tr>
                                <td>{{$prestamo->estudiante}}</td>
                                <td>{{$prestamo->titulo}}</td>
                                <td>{{$prestamo->cantidad}}</td>
                                <td>{{$prestamo->f_prestamo}}</td>
                                <td class="text-danger">{{$prestamo->estado}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-12 mb-3 " style="text-align: right; margin-left: 12px;">
                <div class="col-12 mr-4">
                    <div class="d-flex justify-content-end">
                        {{$prestamos->appends(['busquedaInput' => $busqueda])->onEachSide(1)->render('pagination::bootstrap-5')}}
                    </div>
                </div>
                <a href="{{ route('prestamo.baul') }}" class="btn w-40 my-1 mr-4 btn-a">
                    {{app(App\Http\Controllers\LibrosController::class)->verCantBaulLibro(Auth::user()->id)}}
                    <i class="fa-solid fa-box-archive"></i>
                </a>
                <a href="{{ route('plantilla.index') }}" class="btn w-40 my-1 mr-4 btn-a">
                    <i class="fa-solid fa-inbox"></i> Plantillas
                </a>
            </div>
        </div>
    </div>
</main>
</x-layouts.system>
