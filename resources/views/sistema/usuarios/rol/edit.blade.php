<x-layouts.system
    title2="Actualizar rol"
    iname="Actualizar rol">
    @section('css_tagsinput')
        <link rel="stylesheet" href="{{ asset('/css/bootstrap-tagsinput.css') }}">
    @endsection
    <style>.d-icons{font-size:40px;color:whitesmoke;}</style>
    <main class="container-fluid">
        <div class="card shadow ">
            <div class="card-body">
                <form action="{{ route('rol.update', ['rol' => $role->id]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="rol_id" value="{{ $role->id }}">
                    <div class="form-group">
                        <label for="role_name" class="form-label">Nombre del rol</label>
                        <input type="text" name="role_name" class="form-control" id="role_name" placeholder="Nombre del rol" required
                        value="{{$role->name}}">
                    </div>
                    <div class="form-group">
                        <label for="role_slug" class="form-label">Slug del rol</label>
                        <input type="text" name="role_slug" class="form-control" id="role_slug" placeholder="Slug del rol" required
                        value="{{$role->slug}}">
                    </div>
                    <div class="form-group">
                        <label for="roles_permissions" class="form-label">Agregar permisos</label>
                        <input type="text" data-role="tagsinput" name="roles_permissions" class="form-control" id="roles_permissions"
                        value="@php $trimmedPermissions = []; @endphp
                        @foreach ($role->permissions as $permission)
                            @php $trimmedPermissions[] = trim($permission->name); @endphp
                        @endforeach
                        {{ implode(',', $trimmedPermissions) }}">
                    </div>
                    <div class="form-group pt-2 text-center">
                        <button type="submit" class="btn btn-a">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    @section('js_tagsinput')
        <script type="module" src="{{ asset('/js/bootstrap-tagsinput.js') }}"></script>
        <script>
            $(document).ready(function(){
                $('#role_name').keyup(function(e){
                    var str = $('#role_name').val();
                    str = str.replace(/\s+/g, '-').toLowerCase();
                    $('#role_slug').val(str);
                    $('role_slug') .attr('placeholder', str);
                });
            });
        </script>
    @endsection
</x-layouts.system>
