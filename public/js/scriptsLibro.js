function validarCategoria() {
    var categoriaInput = document.getElementById('categoria');
    categoriaInput.value = categoriaInput.value.replace(/[^a-zA-ZñÑáéíóúÁÉÍÓÚ\s]/g, '');
    categoriaInput.value = categoriaInput.value.slice(0, 30);
}
function validarNrPaginas() {
    var nrpaginasInput = document.getElementById('nrpaginas');
    nrpaginasInput.value = nrpaginasInput.value.replace(/[^0-9]/g, '');
    nrpaginasInput.value = nrpaginasInput.value.slice(0, 11);
}

function validarIdioma() {
    var idiomaInput = document.getElementById('idioma');
    idiomaInput.value = idiomaInput.value.replace(/[^a-zA-ZñÑáéíóúÁÉÍÓÚ]/g, '');
    idiomaInput.value = idiomaInput.value.replace(/\s/g, '');
    idiomaInput.value = idiomaInput.value.slice(0, 20);
}
function validarCantidad() {
    var cantidadInput = document.getElementById('cantidad');
    cantidadInput.value = cantidadInput.value.replace(/[^0-9]/g, '');
    cantidadInput.value = cantidadInput.value.replace(/\s/g, '');
    cantidadInput.value = cantidadInput.value.slice(0, 11);
}
function validarCategoriaEditar() {
    var categoriaInput = document.getElementById('genero');
    categoriaInput.value = categoriaInput.value.replace(/[^a-zA-ZñÑáéíóúÁÉÍÓÚ\s]/g, '');
    categoriaInput.value = categoriaInput.value.slice(0, 30);
}
function validarNrPaginasEditar() {
    var nrpaginasInput = document.getElementById('numpag');
    nrpaginasInput.value = nrpaginasInput.value.replace(/[^0-9]/g, '');
    nrpaginasInput.value = nrpaginasInput.value.replace(/\s/g, '');
    nrpaginasInput.value = nrpaginasInput.value.slice(0, 11);
}
