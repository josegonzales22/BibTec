<x-layouts.system
title2="Ver plantilla"
iname="Ver plantilla">
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
            <div class="form-group">
                <label for="nombre" class="h5 text-dark">Plantilla</label>
                <br>
                <span>{{$plantilla->nombre}}</span>
            </div>
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($plantilla->libros as $libro)
                                <tr>
                                    <td>#{{$libro->id}}</td>
                                    <td>{{$libro->titulo}}</td>
                                    <td>{{$libro->genero}}</td>
                                    <td>{{$libro->cantidad}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-group text-center">
                <form action="{{ route('plantilla.usar', ['plantilla'=>$plantilla->id]) }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-a">Usar</button>
                </form>
            </div>
        </div>
    </div>
</main>
</x-layouts.system>
