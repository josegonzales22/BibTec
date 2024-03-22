<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\EnviarQR;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

require_once(app_path().'/Libraries/phpqrcode/qrlib.php');

class QrController extends Controller
{
    protected $historial;
    public function __construct(HistorialController $historial)
    {
        $this->historial = $historial;
    }
    public function enviarCorreoConQR($email){
        try {
            $rutaImagen = public_path('qrcodes/qr_devolucion.png');
            if (file_exists($rutaImagen)) {
                DB::beginTransaction();
                    Mail::to($email)->send(new EnviarQR($rutaImagen));
                    unlink($rutaImagen);
                    $fecha = new DateTime();
                    $this->historial->store(Auth::user()->id, $fecha, 'Código QR enviado al email de estudiante', null);
                DB::commit();
                return redirect()->route('prestamo.index')->with('status', 'Código QR enviado exitosamente');
            } else {
                return redirect()->route('prestamo.index')->with('status', 'La ruta de la imagen es inválida');
            }
        } catch (\Throwable $th) {
            return redirect()->route('prestamo.index')->with('status', $th->getMessage());
        }
    }
    public function saveQRCode($text, $email)
    {
        try {
            $nombreArchivo = 'qr_devolucion.png';
            $rutaArchivo = public_path('qrcodes/'. $nombreArchivo);
            \QRcode::png($text, $rutaArchivo, 'H', 10, 3);
            return redirect()->route('prestamo.enviarQR', ['email' => $email]);
        } catch (\Throwable $th) {
            return redirect()->route('prestamo.index')->with('status', $th->getMessage());
        }
    }
}
