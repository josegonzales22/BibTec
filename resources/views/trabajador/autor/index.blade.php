<x-layouts.system
title2="Autor"
iname="Autor">
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
                <form action="{{ route('autor.index') }}" method="post" class="form-inline col-12 p-0">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="input-group w-100">
                        <input class="form-control my-0 py-1 red-border" type="text" name="busquedaInput" placeholder="Buscar autor" aria-label="Search">
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
                            <th scope="col">Autor</th>
                            <th scope="col">Libros</th>
                            <th scope="col">F. creación</th>
                            <th scope="col">F. modificación</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody class="fw-light text-secondary">
                        @foreach ($autores as $autor)
                            <tr>
                                <th>{{$autor->id}}</th>
                                <th>{{$autor->info}}</th>
                                <th>{{$autor->cantidad_libros}}</th>
                                <th>{{$autor->created_at}}</th>
                                <th>{{$autor->updated_at}}</th>
                                <th>
                                    <div class='d-flex align-items-center justify-content-center'>
                                        <a href='#' class='btn btn-sm bg-warning text-light mr-1 open-modal' id="id"
                                        data-toggle="modal" data-target="#modalAutor" data-info="{{$autor->info}}" data-id="{{$autor->id}}">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        <form id="eliminarLibroForm" action="{{ route('autor.delete', ['id' => $autor->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm bg-danger text-light mr-1">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-12 mb-3 " style="text-align: right; margin-left: 12px;">
            <div class="col-12 mr-4">
                <div class="d-flex justify-content-end">
                    {{ $autores->appends(['busquedaInput' => $busqueda])->onEachSide(1)->render('pagination::bootstrap-5') }}
                </div>
            </div>
            <a href="" class="btn w-40 my-1 mr-4 btn-a"><i class="fa-solid fa-file-circle-plus"></i>Nuevo</a>
        </div>
    </div>
    <div class="modal fade" id="modalAutor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modificar autor</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('autor.update') }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <label for="info" id="label-autor">Nombres y apellidos del autor</label>
                    <input class="form-control" type="text" name="info" id="info" value=""
                    placeholder="Ej. Pedro Alejandro Pérez Rivera">
                    <input type="hidden" name="id" id="autor_id" value="">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancelar</button>
                  <button type="submit" class="btn btn-a">Guardar</button>
                </div>
            </form>
          </div>
        </div>
    </div>
</main>
<script src="{{ asset('js/jquery/jquery.min.js') }}"></script>
<script type="module" src="{{ asset('js/autor.js') }}"></script>
</x-layouts.system>
