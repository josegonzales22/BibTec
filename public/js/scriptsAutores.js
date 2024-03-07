let contadorAutores = 1;

function agregarAutor() {
    if (contadorAutores < 6) {
        contadorAutores++;

        const autoresContainer = document.getElementById('autoresContainer');
        const nuevoInput = document.createElement('div');
        nuevoInput.className = 'input-group mb-2';
        nuevoInput.innerHTML = `
            <input type="text" class="form-control" name="autores[]" placeholder="Ingrese Autor del Libro" maxlength="100" required>
            <button type="button" style="background-color: #816AFD; color: white;" class="btn btn-secondary"  onclick="eliminarAutor(this)">-</button>
        `;

        autoresContainer.appendChild(nuevoInput);
    }
}

function eliminarAutor(elemento) {
    const autoresContainer = document.getElementById('autoresContainer');
    autoresContainer.removeChild(elemento.parentElement);
    contadorAutores--;
}
