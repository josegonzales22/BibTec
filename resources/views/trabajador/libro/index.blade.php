<x-layouts.system
title2="Libros"
iname="Libros">
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
                <form action="{{ route('libro.index') }}" method="post" class="form-inline col-12 p-0">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="input-group w-100">
                        <input class="form-control my-0 py-1 red-border" type="text" name="busquedaInput" placeholder="Buscar libro" aria-label="Search">
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
                            <th scope="col">Título</th>
                            <th scope="col">Editorial</th>
                            <th scope="col">Año</th>
                            <th scope="col">Categoría</th>
                            <th scope="col">Páginas</th>
                            <th scope="col">Idioma</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Autores</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody class="fw-light text-secondary">
                        @foreach ($libros as $libro)
                            <tr>
                                <th>{{$libro->titulo}}</th>
                                <th>{{$libro->editorial}}</th>
                                <th>{{$libro->pub}}</th>
                                <th>{{$libro->genero}}</th>
                                <th>{{$libro->numpag}}</th>
                                <th>{{$libro->idioma}}</th>
                                <th>{{$libro->cantidad}}</th>
                                <td>{{$libro->Autores}}</td>
                                <td>
                                    <div class='d-flex align-items-center justify-content-center'>
                                        <a href='{{ route('libro.edit', $libro) }}' class='btn btn-sm bg-warning text-light mr-1'>
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        <form id="eliminarLibroForm" action="{{ route('libro.delete', $libro->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm bg-danger text-light mr-1">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                        <a href='' class='btn btn-sm bg-primary text-light mr-1'>
                                            <i class="fa-solid fa-box-archive"></i>
                                        </a>
                                        <a href='' class='btn btn-sm bg-info text-light mr-1'>
                                            <i class="fa-solid fa-inbox"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-12 mb-3 " style="text-align: right; margin-left: 12px;">
            <div class="col-12 mr-4">
                <div class="d-flex justify-content-end">
                    {{ $libros->appends(['busquedaInput' => $busqueda])->onEachSide(1)->render('pagination::bootstrap-5') }}
                </div>
            </div>
            <a href="{{ route('autor.index') }}" class="btn w-40 my-1 mr-4 btn-a"><i class="fa-solid fa-users"></i>Autor</a>
            <a href="{{ route('libro.new') }}" class="btn w-40 my-1 mr-4 btn-a"><i class="fa-solid fa-file-circle-plus"></i>Nuevo</a>
        </div>
    </div>
</main>
</x-layouts.system>
