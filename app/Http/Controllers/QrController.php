<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrController extends Controller
{
    public function generateQR($texto, $email)
    {
        try {
            $codigoQR = QrCode::size(300)->generate($texto);
            $nombreArchivoSVG = 'qr_code.svg';
            $rutaArchivoSVG = public_path($nombreArchivoSVG);
            file_put_contents($rutaArchivoSVG, $codigoQR);
            return redirect()->route('convertPNG')->with('email', $email);
        } catch (\Throwable $th) {
            return redirect()->route('prestamo.index')->with('status', $th->getMessage());
        }
    }
    public function guardarPNGPublic(Request $request)
    {
        try {
            $imagenData = $request->input('image');
            $email = $request->input('email');
            $imagenBinaria = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imagenData));
            $nombreArchivo = 'codigoQR.png';
            $rutaArchivo = public_path($nombreArchivo);
            file_put_contents($rutaArchivo, $imagenBinaria);
            return $this->enviarCorreoConQR($email);
        } catch (\Throwable $th) {
            return redirect()->route('prestamo.index')->with('status', $th->getMessage());
        }
    }
    public function convertSVGtoPNG(){
        return view('sistema.convert.png');
    }
    public function enviarCorreoConQR($email){
        try {
            $rutaImagen = public_path('codigoQR.png');
            if (file_exists($rutaImagen)) {
                Mail::to($email)->send(new EnviarQR($rutaImagen));
                $rutaSVG = public_path('qr_code.svg');
                if (file_exists($rutaSVG)) {
                    unlink($rutaSVG);
                }
                unlink($rutaImagen);
                return redirect()->route('prestamo.index')->with('status', 'Código QR enviado exitosamente');
            } else {
                return redirect()->route('prestamo.index')->with('status', 'La ruta de la imagen es inválida');
            }
        } catch (\Throwable $th) {
            return redirect()->route('prestamo.index')->with('status', $th->getMessage());
        }
    }
}
