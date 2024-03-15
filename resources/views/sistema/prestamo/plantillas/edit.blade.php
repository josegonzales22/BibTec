<x-layouts.system
title2="Editar plantilla"
iname="Editar plantilla">
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
            <form action="{{ route('plantilla.update.nombre') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nombre" class="h5 text-dark">Plantilla</label>
                    <br>
                    <div class="input-group w-100">
                        <input type="hidden" name="idP" value="{{$plantilla->id}}" id="idP">
                        <input class="form-control my-0 py-1 red-border" type="text"
                        name="nombreP" placeholder="Ej. Plantilla 1" value="{{$plantilla->nombre}}">
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-a" type="submit">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="form-group">
                <label for="libros" class="h5 text-dark">Libros asociados</label>
                <br>
                <div class="table-responsive" style="overflow-y:auto;height:50vh;">
                    <table class="table table-bordered table-hover">
                        <thead class="sticky-top bg-white">
                            <tr class="text-dark">
                                <th><i class="fa-solid fa-book-bookmark"></i> Id</th>
                                <th>Título</th>
                                <th>Categoría</th>
                                <th>Stock</th>
                                <th class="text-center">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($plantilla->libros as $libro)
                                <tr>
                                    <td>#{{$libro->id}}</td>
                                    <td>{{$libro->titulo}}</td>
                                    <td>{{$libro->genero}}</td>
                                    <td>{{$libro->cantidad}}</td>
                                    <td class="text-center">
                                        <form action="{{ route('plantilla.delete.libro',[
                                            'plantilla' => $plantilla->id,
                                            'libro' => $libro->id
                                            ]) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm bg-danger text-white">
                                                <i class="fa-solid fa-x"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
</x-layouts.system>
