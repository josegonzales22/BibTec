<x-layouts.system
title2="Historial"
iname="Historial">
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
            @if (app(App\Http\Controllers\HistorialController::class)->checkTableHistorialIsNotEmpty())
            <div class="input-group md-form form-sm form-2 pl-0">
                <form action="{{ route('historial.index') }}" method="post" class="form-inline col-12 p-0">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="input-group w-100">
                        <input class="form-control my-0 py-1 red-border" type="text" name="busquedaInput" placeholder="Buscar operación" aria-label="Search">
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
                            <th scope="col">Id</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Operación</th>
                            <th scope="col">Libro</th>
                        </tr>
                    </thead>
                    <tbody class="fw-light text-secondary">
                        @foreach ($resultados as $resultado)
                            <tr>
                                <td>{{$resultado->id}}</td>
                                <td>{{$resultado->usuario}}</td>
                                <td>{{$resultado->fecha}}</td>
                                <td>{{$resultado->operacion}}</td>
                                @if (!$resultado->titulo)
                                    <td class="text-center">-</td>
                                @else
                                    <td>{{$resultado->titulo}}</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-12 mb-3 " style="text-align: right; margin-left: 12px;">
                <div class="col-12 mr-4">
                    <div class="d-flex justify-content-end">
                        {{ $resultados->appends(['busquedaInput' => $busqueda])->onEachSide(1)->render('pagination::bootstrap-5') }}
                    </div>
                </div>
                <a href="" class="btn w-40 my-1 mr-4 btn-a" data-toggle="modal" data-target="#expModal"><i class="fa-solid fa-file-csv"></i>Exportar</a>
                <a href="{{ route('historial.index') }}" class="btn w-40 my-1 mr-4 btn-a"><i class="fa-solid fa-rotate-right"></i>Actualizar</a>
            </div>
            @else
                <x-layouts.empty/>
            @endif
        </div>
    </div>
</main>
<div class="modal fade" id="expModal" tabindex="-1" role="dialog" aria-labelledby="expModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Descargar reportes</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form class="form-submit" action="{{ route('historial.export', ['op'=>1]) }}" method="post" id="formExport">
                @csrf
                <a href="#" class="submit-link text-system" id="link">Reporte usuarios <i class="fa-solid fa-download"></i></a>
            </form>
            <form class="form-submit" action="{{ route('historial.export', ['op'=>2]) }}" method="post">
                @csrf
                <a href="#" class="submit-link text-system">Reporte historial <i class="fa-solid fa-download"></i></a>
            </form>
            <form class="form-submit" action="{{ route('historial.export', ['op'=>3]) }}" method="post">
                @csrf
                <a href="#" class="submit-link text-system">Reporte libros <i class="fa-solid fa-download"></i></a>
            </form>
            <form class="form-submit" action="{{ route('historial.export', ['op'=>4]) }}" method="post">
                @csrf
                <a href="#" class="submit-link text-system">Reporte préstamos <i class="fa-solid fa-download"></i></a>
            </form>
            <form class="form-submit" action="{{ route('historial.export', ['op'=>5]) }}" method="post">
                @csrf
                <a href="#" class="submit-link text-system">Reporte devoluciones <i class="fa-solid fa-download"></i></a>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<script src="{{ asset('js/jquery/jquery.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $(".submit-link").click(function(e){
            e.preventDefault();
            $(this).closest('form').submit();
        });
    });
</script>
</x-layouts.system>
