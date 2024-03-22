<x-layouts.system
title2="Roles de usuario"
iname="Roles">
@section('css_tagsinput')
        <link rel="stylesheet" href="{{ asset('/css/bootstrap-tagsinput.css') }}">
@endsection
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
                <form action="{{ route('rol.index') }}" method="post" class="form-inline col-12 p-0">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="input-group w-100">
                        <input class="form-control my-0 py-1 red-border" type="text" name="busquedaInput" placeholder="Buscar rol" aria-label="Search">
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
                            <th scope="col">id</th>
                            <th scope="col">Rol</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Permissions</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody class="fw-light text-secondary">
                        @foreach ($roles as $rol)
                            <tr>
                                <td>{{$rol->id}}</td>
                                <td>{{$rol->name}}</td>
                                <td>{{$rol->slug}}</td>
                                <td>
                                    @if ($rol->permissions != null)
                                        @foreach ($rol->permissions as $permission)
                                            <span class="badge badge-info">
                                                {{$permission->name}}
                                            </span>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-sm bg-primary text-light" href="/usuarios/roles/{{$rol->id}}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a class="btn btn-sm bg-warning text-light" href="/usuarios/roles/{{$rol->id}}/edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a class="btn btn-sm bg-danger text-light open-modal" href="#"
                                    data-toggle="modal" data-target="#deleteModal" data-roleid="{{$rol->id}}">
                                        <i class="fa fa-trash"></i>
                                    </a>
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
                    {{ $roles->appends(['busquedaInput' => $busqueda])->onEachSide(1)->render('pagination::bootstrap-5') }}
                </div>
            </div>
            <a href="/usuarios/roles/crear" class="btn w-40 my-1 mr-4 btn-a">
                <i class="fa-solid fa-file-circle-plus"></i> Nuevo
            </a>
        </div>
    </div>
</main>
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar rol</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="question">¿Estás seguro de eliminar este rol?</label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancelar</button>
                <form action="/usuarios/roles/delete" method="post">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="role_id" id="role_id" value="">
                    <button type="button" class="btn btn-a" onclick="$(this).closest('form').submit();">Aceptar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('js/rol.js') }}"></script>
@section('js_tagsinput')
    <script type="module" src="{{ asset('/js/bootstrap-tagsinput.js') }}"></script>
@endsection
</x-layouts.system>
