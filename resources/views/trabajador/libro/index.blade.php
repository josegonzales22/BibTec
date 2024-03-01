<x-layouts.system
title2="Libros"
iname="Libros">
<style>.d-icons{font-size:40px;color:whitesmoke;}</style>
<main class="container-fluid">
    <div class="card shadow ">
        <div class="card-body">
            <div class="input-group md-form form-sm form-2 pl-0">
                <input class="form-control my-0 py-1 red-border" type="text" id="busquedaInput" oninput="buscarEnTabla()" placeholder="Buscar libro" aria-label="Search">
                <div class="input-group-append">
                    <span class="input-group-text red lighten-3" id="basic-text1" style="background-color: #816AFD">
                        <i class="fas fa-search" aria-hidden="true" style="color:#fff;"></i>
                    </span>
                </div>
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
                        <tr>
                            <th>Titulo1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                            <th>Titulo1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                            <th>Titulo1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col mb-3 mt-3" style="text-align: right; margin-left: 12px;">
            <a href="" class="btn w-40 my-1 mr-4 btn-a">Autores</a>
            <a href="" class="btn w-40 my-1 mr-4 btn-a">Nuevo</a>
        </div>
    </div>
    <div class="modal fade" id="eliminarLibroModal" tabindex="-1" role="dialog" aria-labelledby="eliminarLibroModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarLibroModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este libro?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn " style="background-color: #816AFD; color: white;" id="eliminarLibroBtn">Sí</button>
                </div>
            </div>
        </div>
    </div>
</main>
</x-layouts.system>
