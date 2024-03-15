<x-layouts.system
title2="Ver rol"
iname="Ver rol">
<style>.d-icons{font-size:40px;color:whitesmoke;}</style>
<main class="container-fluid">
    <div class="card shadow ">
        <div class="card-header">
            <h3>Nombre: {{$role['name']}}</h3>
            <h4>Slug: {{$role['slug']}}</h4>
        </div>
        <div class="card-body">
            <h5 class="card-title">Permisos</h5>
            <p class="card-text">
                ...............
            </p>
        </div>
        <div class="card-footer">
            <a class="btn btn-a" href="{{ url()->previous() }}">Regresar</a>
        </div>
    </div>
</main>
</x-layouts.system>
