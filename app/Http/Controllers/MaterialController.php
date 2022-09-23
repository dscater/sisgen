<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public $validacion = [
        'codigo' => 'required|min:1|unique:materials,codigo',
        'nombre' => 'required|min:4',
        'descripcion' => 'nullable|min:4',
        'propietario' => 'required|min:4',
        'puesto_vigilancia_id' => 'required',
    ];

    public function index(Request $request)
    {
        $materials = Material::all();
        return response()->JSON(['materials' => $materials, 'total' => count($materials)]);
    }

    public function store(Request $request)
    {
        $request->validate($this->validacion);
        $request['fecha_registro'] = date('Y-m-d');
        $material = Material::create(array_map('mb_strtoupper', $request->all()));
        return response()->JSON([
            'msj' => 'Registro éxitoso',
            'material' => $material
        ]);
    }

    public function update(Material $material, Request $request)
    {
        $this->validacion['codigo'] = 'required|min:1|unique:materials,codigo,' . $material->id;
        $request->validate($this->validacion);
        $material->update(array_map('mb_strtoupper', $request->all()));
        return response()->JSON([
            'msj' => 'Actualización éxitosa',
            'material' => $material
        ]);
    }

    public function destroy(Material $material)
    {
        $material->delete();
        return response()->JSON(['msj' => 'Registro eliminado']);
    }
}
