<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use UrlSigner;
use stdClass;
use PDF;
use Intervention\Image\Facades\Image;

class ModeloController extends Controller
{
    public function index()
    {
        $response = new stdClass();

        $modelos = Modelo::all();

        $response->success = true;
        $response->data = $modelos;
        $response->error = [];
        return response()
            ->json($response);
    }

    public function store(Request $request)
    {
        if ($imagen_url = Modelo::setImagen($request->imagen))
            $request->request->add(['imagen_url' => $imagen_url]);
        // $modelo = Modelo::create($request->all());
        // return $modelo;
    }

    public function show(Modelo $modelo)
    {
        return $modelo;
    }

    public function update(Request $request, Modelo $modelo)
    {
        //
    }

    public function destroy(Modelo $modelo)
    {
        //
    }

    public function showModelo()
    {
        return view('modelo.index');
    }

    public function getArchivo(Request $request)
    {
        $tipo = $request->tipo;
        $nombre = $request->nombre;
        $usuario = $request->usuario;

        if($tipo == "pdf") {
            $path = storage_path('app/public/files/' . $nombre);

            return Response::make(file_get_contents($path), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $nombre . '"'
            ]);
        }

        if($tipo == "jpg" || $tipo == "png" ||$tipo == "jpeg" ) {
            return Image::make(storage_path('app/public/files/' . $nombre))->response();
        }
    }
}
