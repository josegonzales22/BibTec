<x-layouts.system
title2="Baul devoluciones"
iname="Baul devoluciones">
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
            @if (!app(App\Http\Controllers\DevolucionController::class)->checkBaulDevolucionIsEmpty())
                <x-layouts.empty/>
            @else
                <div class="table-responsive mt-3" style="overflow-y:auto;height:50vh;">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr class="font-weight-bold text-dark">
                                <th scope="col">Id</th>
                                <th scope="col">Estudiante</th>
                                <th scope="col">Libro</th>
                                <th scope="col">F. préstamo</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody class="fw-light text-secondary">
                            @foreach ($prestamos as $prestamo)
                                <tr>
                                    <td>{{$prestamo->id}}</td>
                                    <td>{{$prestamo->Estudiante}}</td>
                                    <td>{{$prestamo->Libro}}</td>
                                    <td>{{$prestamo->f_prestamo}}</td>
                                    <td class="text-danger">{{$prestamo->estado}}</td>
                                    <td>
                                        <form action="{{ route('dbaul.delete', ['user' => Auth::user()->id, 'prestamo' => $prestamo->IdPrestamo]) }}" method="post">
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
                <div class="text-center">
                    <form action="{{ route('dbaul.process', ['user'=>Auth::user()->id]) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-a">Finalizar</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</main>
</x-layouts.system>
