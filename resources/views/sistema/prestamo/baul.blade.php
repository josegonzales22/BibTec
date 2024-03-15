<x-layouts.system
title2="Baul préstamos"
iname="Baul préstamos">
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
            <div class="table-responsive mt-3" style="overflow-y:auto;height:50vh;">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="font-weight-bold text-dark">
                            <th scope="col">Titulo</th>
                            <th scope="col">Categoría</th>
                            <th scope="col">Páginas</th>
                            <th scope="col">Idioma</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody class="fw-light text-secondary">
                        @foreach ($libros as $libro)
                            <tr>
                                <td>{{$libro->titulo}}</td>
                                <td>{{$libro->genero}}</td>
                                <td>{{$libro->numpag}}</td>
                                <td>{{$libro->idioma}}</td>
                                <td>
                                    <form action="{{ route('prestamo.deleteFromBaul', ['user' => Auth::user()->id, 'book' => $libro->id]) }}" method="post">
                                        @csrf
                                        <button type="submit" class='btn btn-sm bg-danger text-light mr-1' title="Eliminar del baúl">
                                            <i class="fa-solid fa-x"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="form-group">
                <form action="{{ route('prestamo.store') }}" method="post">
                    @csrf
                    <label for="dniEstudiante">Documento Nacional de Identidad</label>
                    <input type="text" class="form-control" id="dniEstudiante" name="dniEstudiante" placeholder="Ingrese el dni del estudiante">
                    <div class="text-center mt-3">
                        <button class="btn btn-a">Finalizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
</x-layouts.system>
