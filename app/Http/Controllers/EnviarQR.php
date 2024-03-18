<?php

namespace App\Http\Controllers;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnviarQR extends Mailable{
    use Queueable, SerializesModels;
    public $rutaImagen;
    public $titulo = 'Código QR de sus préstamos';
    public $mensaje =
    'Estimado estudiante, aquí le hacemos envío de su código QR que deberá presentar al momento
    de la devolución de los libros';

    public function __construct($rutaImagen)
    {
        $this->rutaImagen = $rutaImagen;
    }

    public function build()
    {
        return $this->view('sistema.convert.png')
                    ->subject($this->titulo)
                    ->html('<p>'.$this->mensaje.'<p>')
                    ->attach($this->rutaImagen, ['as' => 'codigoQR.png', 'mime' => 'image/png']);
    }
}
