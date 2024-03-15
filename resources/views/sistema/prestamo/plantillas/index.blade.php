<x-layouts.system
title2="Plantillas"
iname="Plantillas">
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
            @if (app(App\Http\Controllers\PrestamoController::class)->checkTablePlantillaIsNotEmpty())
                <div class="table-responsive mt-3" style="overflow-y:auto;height:50vh;">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr class="font-weight-bold text-dark">
                                <th scope="col">Id</th>
                                <th scope="col">Título</th>
                                <th scope="col">Libros</th>
                                <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody class="fw-light text-secondary">
                            @foreach ($plantillas as $plantilla)
                                <tr>
                                    <td>{{$plantilla->id}}</td>
                                    <td>{{$plantilla->nombre}}</td>
                                    <td>{{$plantilla->libros_count}}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-12 mb-3 " style="text-align: right; margin-left: 12px;">
                    <a href="" class="btn w-40 my-1 btn-a" data-toggle="modal" data-target="#plantillaModal">
                        <i class="fa-solid fa-file"></i> Nuevo
                    </a>
                </div>
            @else
                <x-layouts.empty-modal modalName="#plantillaModal"/>
            @endif
        </div>
    </div>
    <div class="modal fade" id="plantillaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Agregar plantilla</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('plantilla.save') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="plantillaName">Nombre</label>
                        <input type="text" class="form-control" id="plantillaName" name="plantillaName"
                        placeholder="Ej. Libros de primer grado" maxlength="50">
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                  <button type="submit" class="btn btn-a">Finalizar</button>
                </div>
            </form>
          </div>
        </div>
    </div>
</main>
</x-layouts.system>
