<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Personal;
use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    public $validacion = [
        'personal_id' => 'required',
        'tipo' => 'required',
        'hora' => 'required',
        'fecha' => 'required',
    ];

    public function index(Request $request)
    {
        $asistencias = Asistencia::orderBy('created_at', 'desc')->get();
        return response()->JSON(['asistencias' => $asistencias, 'total' => count($asistencias)]);
    }

    public function store(Request $request)
    {
        $request->validate($this->validacion);
        $request['fecha_registro'] = date('Y-m-d');
        $existe = Asistencia::where('fecha', $request->fecha)->where('personal_id', $request->personal_id)->where('tipo', $request->tipo)->get()->first();
        if (!$existe) {
            $asistencia = Asistencia::create(array_map('mb_strtoupper', $request->all()));
            return response()->JSON([
                'msj' => 'Registro éxitoso',
                'asistencia' => $asistencia
            ]);
        }
    }

    public function update(Asistencia $asistencia, Request $request)
    {
        $request->validate($this->validacion);
        $asistencia->update(array_map('mb_strtoupper', $request->all()));
        return response()->JSON([
            'msj' => 'Actualización éxitosa',
            'asistencia' => $asistencia
        ]);
    }

    public function destroy(Asistencia $asistencia)
    {
        $asistencia->delete();
        return response()->JSON(['msj' => 'Registro eliminado']);
    }

    public function getTipo(Request $request)
    {
        $personal = Personal::where('ci', $request->ci)->get()->first();
        if ($personal) {
            $fecha = date("Y-m-d");
            $tipo = 'INGRESO';
            $asistencia = Asistencia::where('fecha', $fecha)->where('personal_id', $personal->id)->get()->first();
            if ($asistencia) {
                $tipo = 'SALIDA';
            }
            return response()->JSON(['sw' => true, 'personal' => $personal, 'tipo' => $tipo, 'fecha' => $fecha]);
        }
        return response()->JSON(['sw' => false]);
    }
}
