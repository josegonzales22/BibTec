<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Código QR con Javascript</title>
    <script src="https://cdn.jsdelivr.net/npm/qrious"></script>
</head>
<body>
    <div class="contenedor">
        <form id="formulario" class="formulario" action="{{ route('test') }}" method="POST">
            @csrf
            <input type="text" id="link" name="link" placeholder="Escribe el texto o URL" />
            <input type="hidden" id="qrImageData" name="qrImageData">
            <button type="button" class="btn" onclick="generateQR()">Generar y Guardar QR</button>
        </form>
        <div id="contenedorQR" class="contenedorQR"></div>
    </div>

    <script>
        function generateQR() {
            const qrData = document.getElementById('link').value;
            const qrCanvas = document.createElement('canvas');
            new QRious({
                element: qrCanvas,
                value: qrData,
                size: 200, // Tamaño del código QR
                padding: 20 // Margen
            });
            const imageData = qrCanvas.toDataURL('image/png');
            document.getElementById('qrImageData').value = imageData;
            document.getElementById('formulario').submit(); // Envía el formulario después de actualizar el campo oculto
        }
    </script>
</body>
</html>
