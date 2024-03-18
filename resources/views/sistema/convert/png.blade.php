<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Enviar QR | BibTec</title>
    <link rel="shortcut icon" href="{{ asset('img/icon.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>body{overflow-x: hidden;overflow-y: hidden;}
</style>
<body>
    <div class="justify-content-center align-items-center text-secondary" style="height: 100vh; display:flex;" id="loader">
        <div class="spinner-border " role="status" >
            <span class="sr-only"></span>
        </div>
    </div>
    <div id="codigoQR"></div>
    <form id="formGuardarImagen" action="/guardar-imagen" method="POST">
        @csrf
        <input type="hidden" id="imageData" name="image">
        @if(session('email'))
            <input type="hidden" name="email" value="{{ session('email') }}">
        @endif
        <button type="submit" id="guardarImagen" style="display: none;">Guardar imagen</button>
    </form>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script>
        var rutaSVG = "qr_code.svg";
        var img = new Image();
        img.src = rutaSVG;
        img.onload = function() {
            document.getElementById('codigoQR').appendChild(img);
            document.getElementById('guardarImagen').click();
        };
        document.getElementById('formGuardarImagen').addEventListener('submit', function(event) {
            event.preventDefault();
            html2canvas(document.getElementById('codigoQR').getElementsByTagName('img')[0]).then(function(canvas) {
                var imageData = canvas.toDataURL("image/png");
                document.getElementById('imageData').value = imageData;
                document.getElementById('formGuardarImagen').submit();
            });
        });
    </script>
</body>
</html>
