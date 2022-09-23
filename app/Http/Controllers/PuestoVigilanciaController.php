<?php

namespace App\Http\Controllers;

use App\Models\PuestoVigilancia;
use Illuminate\Http\Request;

class PuestoVigilanciaController extends Controller
{
    public $validacion = [
        'nombre' => 'required|min:4|unique:puesto_vigilancias,nombre',
        'descripcion' => 'nullable|min:4',
        'personal' => 'required|numeric|min:1',
        'estado' => 'required',
    ];

    public function index(Request $request)
    {
        $puesto_vigilancias = PuestoVigilancia::all();
        return response()->JSON(['puesto_vigilancias' => $puesto_vigilancias, 'total' => count($puesto_vigilancias)]);
    }

    public function store(Request $request)
    {
        $request->validate($this->validacion);
        $request['fecha_registro'] = date('Y-m-d');
        $puesto_vigilancia = PuestoVigilancia::create(array_map('mb_strtoupper', $request->all()));
        return response()->JSON([
            'msj' => 'Registro éxitoso',
            'puesto_vigilancia' => $puesto_vigilancia
        ]);
    }

    public function update(PuestoVigilancia $puesto_vigilancia, Request $request)
    {
        $this->validacion['nombre'] = 'required|min:4|unique:puesto_vigilancias,nombre,' . $puesto_vigilancia->id;
        $request->validate($this->validacion);
        $puesto_vigilancia->update(array_map('mb_strtoupper', $request->all()));
        return response()->JSON([
            'msj' => 'Actualización éxitosa',
            'puesto_vigilancia' => $puesto_vigilancia
        ]);
    }

    public function destroy(PuestoVigilancia $puesto_vigilancia)
    {
        $puesto_vigilancia->delete();
        return response()->JSON(['msj' => 'Registro eliminado']);
    }

    public function getLista()
    {
        return response()->JSON(PuestoVigilancia::all());
    }
}
