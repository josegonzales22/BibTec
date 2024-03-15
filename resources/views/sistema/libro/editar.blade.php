<x-layouts.system
title2="Editar libro"
iname="Editar">
<main class="container-fluid">
    <div class="card shadow ">
        <div class="card-body">
            <form action="{{ route('libro.update', ['libro' => $libro->id]) }}" method="post" class="d-inline">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-xl-4 col-md-4 col-lg-12 mb-2">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" value="{{$libro->titulo}}"
                        maxlength="100" placeholder="Ingrese Título del Libro"  required>
                        @error('titulo')
                            <br>
                            <small style="color:red;">{{$message}}</small>
                        @enderror
                    </div>
                    <div class=" col-xl-4 col-md-4 col-lg-12 mb-2">
                        <label for="editorial" class="form-label">Editorial</label>
                        <input type="text" class="form-control" id="editorial" name="editorial"
                        maxlength="100" placeholder="Ingrese Editorial del Libro" value="{{$libro->editorial}}" required>
                        @error('editorial')
                            <br>
                            <small style="color:red;">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-xl-4 col-md-4 col-lg-12 mb-2">
                        <label for="anio" class="form-label">Año Publicación</label>
                        <input type="number" class="form-control" id="pub" name="pub" placeholder="Fecha de publicación"
                        value="{{$libro->pub}}" required>
                        @error('pub')
                            <br>
                            <small style="color:red;">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-xl-4 col-md-4 col-lg-12 mb-2">
                        <label for="categoria" class="form-label">Categoría</label>
                        <input type="text" class="form-control" id="genero" name="genero" maxlength="30"
                        placeholder="Ingrese Categoria del Libro" oninput="validarCategoria()"
                        value="{{$libro->genero}}" required>
                        @error('genero')
                            <br>
                            <small style="color:red;">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-xl-4 col-md-4 col-lg-12 mb-2">
                        <label for="numpag" class="form-label">Número Total Páginas</label>
                        <input type="text" class="form-control" id="numpag" name="numpag" maxlength="11"
                        placeholder="Ingrese Total de Número de Páginas del Libro" oninput="validarNrPaginas()"
                        value="{{$libro->numpag}}" required>
                        @error('numpag')
                            <br>
                            <small style="color:red;">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-xl-4 col-md-4 col-lg-12 mb-2">
                        <label for="idioma" class="form-label">Idioma</label>
                        <input type="text" class="form-control" id="idioma" name="idioma" maxlength="20"
                        placeholder="Ingrese Idioma del Libro" oninput="validarIdioma()"
                        value="{{$libro->idioma}}" required>
                        @error('idioma')
                            <br>
                            <small style="color:red;">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-xl-4 col-md-4 col-lg-12 mb-2">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <input type="text" class="form-control" id="cantidad" name="cantidad"
                        placeholder="Ingrese Cantidad de Libros" maxlength="11" oninput="validarCantidad()"
                        value="{{$libro->cantidad}}" required>
                        @error('cantidad')
                            <br>
                            <small style="color:red;">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-12 mb-3 mt-3" style="text-align: right; margin-left: 12px;">
                    <a href="{{ route('libro.index') }}" class="btn w-40 my-1 mr-4 btn-b">Regresar</a>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button class="btn w-40 my-1 mr-4 btn-a">
                        <i class="fa-solid fa-floppy-disk"></i> Editar
                    </button>
                </div>
            </form>
            </div>
        </div>
    </div>
</main>
<script src="{{ asset('js/scriptsAutores.js') }}"></script>
<script src="{{ asset('js/scriptsLibro.js') }}"></script>
</x-layouts.system>
