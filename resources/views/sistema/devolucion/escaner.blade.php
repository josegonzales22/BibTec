<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Escáner | BibTec</title>
    @vite('resources/css/scan.css')
  </head>
  <body>
    <div id="container">
        <div id="reader"></div>
        <h2 id="scanResultText"></h2>
        <a id="scanResultUrl" target="_blank"></a>
        <button id="refreshButton" onclick="refreshScanner()">New Scan</button>
        <a href="{{ route('devolucion.index') }}" class="btn btn-a">Regresar</a>
    </div>
    <script src="{{ asset('js/scan/html5-qrcode.min.js') }}"></script>
    <script>
      function onScanSuccess(decodedText, decodedResult) {
        console.log(`Scan result: ${decodedText}`, decodedResult);
        if (isValidUrl(decodedText)) {
            var scanResultLink = document.getElementById("scanResultUrl");
            scanResultLink.href = decodedText;
            scanResultLink.innerText = decodedText;
        } else {
            document.getElementById("scanResultText").textContent = `Scan result: ${decodedText}`;
        }
        html5QrcodeScanner.clear();
        document.getElementById("refreshButton").style.display = "block";
      }
      function refreshScanner() {
        location.reload(true);
      }
      function isValidUrl(url) {
        var pattern = new RegExp(
          "^(https?:\\/\\/)?" +
            "((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|" +
            "((\\d{1,3}\\.){3}\\d{1,3}))" +
            "(\\:\\d+)?(\\/[-a-z\\d%@_.~+&:]*)*" +
            "(\\?[;&a-z\\d%@_.,~+&:=-]*)?" +
            "(\\#[-a-z\\d_]*)?$",
          "i"
        );
        return !!pattern.test(url);
      }
      var html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 });
      html5QrcodeScanner.render(onScanSuccess);
    </script>
  </body>
</html>
