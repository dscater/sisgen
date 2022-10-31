<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Models\Generacion;
use App\Models\Personal;
use App\Models\PuestoVigilancia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsignacionController extends Controller
{
    public $validacion = [
        'cant_min_per_alto' => 'required|numeric|min:1',
        'cant_min_sup_alto' => 'required|numeric|min:1',
        'cant_min_guar_alto' => 'required|numeric|min:1',
        'cant_max_per_alto' => 'required|numeric|min:1',
        'cant_max_guar_alto' => 'required|numeric|min:1',
        'cant_min_per_medio' => 'required|numeric|min:1',
        'cant_min_sup_medio' => 'required|numeric|min:1',
        'cant_min_guar_medio' => 'required|numeric|min:1',
        'cant_max_per_medio' => 'required|numeric|min:1',
        'cant_max_guar_medio' => 'required|numeric|min:1',
        'cant_min_per_basico' => 'required|numeric|min:1',
        'cant_min_sup_basico' => 'required|numeric|min:1',
        'cant_min_guar_basico' => 'required|numeric|min:1',
        'cant_max_per_basico' => 'required|numeric|min:1',
        'cant_max_guar_basico' => 'required|numeric|min:1',
        'cant_min_experto' => 'required|numeric|min:1',
        'cant_max_experto' => 'required|numeric|min:1',
        'cant_min_moderado' => 'required|numeric|min:1',
        'cant_max_moderado' => 'required|numeric|min:1',
        'cant_min_intermedio' => 'required|numeric|min:1',
        'cant_max_intermedio' => 'required|numeric|min:1',
        'cant_min_principiante' => 'required|numeric|min:1',
        'cant_max_principiante' => 'required|numeric|min:1',
    ];

    public $messages = [
        'cant_min_per_alto.required' => 'Debes completar este campo',
        'cant_min_sup_alto.required' => 'Debes completar este campo',
        'cant_min_guar_alto.required' => 'Debes completar este campo',
        'cant_max_per_alto.required' => 'Debes completar este campo',
        'cant_max_guar_alto.required' => 'Debes completar este campo',
        'cant_min_per_medio.required' => 'Debes completar este campo',
        'cant_min_sup_medio.required' => 'Debes completar este campo',
        'cant_min_guar_medio.required' => 'Debes completar este campo',
        'cant_max_per_medio.required' => 'Debes completar este campo',
        'cant_max_guar_medio.required' => 'Debes completar este campo',
        'cant_min_per_basico.required' => 'Debes completar este campo',
        'cant_min_sup_basico.required' => 'Debes completar este campo',
        'cant_min_guar_basico.required' => 'Debes completar este campo',
        'cant_max_per_basico.required' => 'Debes completar este campo',
        'cant_max_guar_basico.required' => 'Debes completar este campo',
        'cant_min_experto.required' => 'Debes completar este campo',
        'cant_max_experto.required' => 'Debes completar este campo',
        'cant_min_moderado.required' => 'Debes completar este campo',
        'cant_max_moderado.required' => 'Debes completar este campo',
        'cant_min_intermedio.required' => 'Debes completar este campo',
        'cant_max_intermedio.required' => 'Debes completar este campo',
        'cant_min_principiante.required' => 'Debes completar este campo',
        'cant_max_principiante.required' => 'Debes completar este campo',

        'cant_min_per_alto.min' => 'Debes ingresar un número mayor o igual a 1',
        'cant_min_sup_alto.min' => 'Debes ingresar un número mayor o igual a 1',
        'cant_min_guar_alto.min' => 'Debes ingresar un número mayor o igual a 1',
        'cant_max_per_alto.min' => 'Debes ingresar un número mayor o igual a 1',
        'cant_max_guar_alto.min' => 'Debes ingresar un número mayor o igual a 1',
        'cant_min_per_medio.min' => 'Debes ingresar un número mayor o igual a 1',
        'cant_min_sup_medio.min' => 'Debes ingresar un número mayor o igual a 1',
        'cant_min_guar_medio.min' => 'Debes ingresar un número mayor o igual a 1',
        'cant_max_per_medio.min' => 'Debes ingresar un número mayor o igual a 1',
        'cant_max_guar_medio.min' => 'Debes ingresar un número mayor o igual a 1',
        'cant_min_per_basico.min' => 'Debes ingresar un número mayor o igual a 1',
        'cant_min_sup_basico.min' => 'Debes ingresar un número mayor o igual a 1',
        'cant_min_guar_basico.min' => 'Debes ingresar un número mayor o igual a 1',
        'cant_max_per_basico.min' => 'Debes ingresar un número mayor o igual a 1',
        'cant_max_guar_basico.min' => 'Debes ingresar un número mayor o igual a 1',
        'cant_min_experto.min' => 'Debes ingresar un número mayor o igual a 1',
        'cant_max_experto.min' => 'Debes ingresar un número mayor o igual a 1',
        'cant_min_moderado.min' => 'Debes ingresar un número mayor o igual a 1',
        'cant_max_moderado.min' => 'Debes ingresar un número mayor o igual a 1',
        'cant_min_intermedio.min' => 'Debes ingresar un número mayor o igual a 1',
        'cant_max_intermedio.min' => 'Debes ingresar un número mayor o igual a 1',
        'cant_min_principiante.min' => 'Debes ingresar un número mayor o igual a 1',
        'cant_max_principiante.min' => 'Debes ingresar un número mayor o igual a 1',
    ];

    public function index(Request $request)
    {
        $generacion = Generacion::get()->last();
        $asignacions = [];
        if ($generacion) {
            $asignacions = $generacion->asignacions;
        }
        return response()->JSON(['asignacions' => $asignacions, 'total' => count($asignacions)]);
    }

    public function getResultado(Request $request)
    {
        $request->validate($this->validacion, $this->messages);

        // VALIDAR PERSONAL EXISTENTE CON LA SUMATORIA DEL PERSONAL REQUERIDO DE LOS PUESTOS DE VIGILANCIA
        $personal_existente = Personal::select("id")->where('estado', 'ACTIVO')->get();
        $total_personal_requerido = PuestoVigilancia::where('estado', 'ACTIVO')->sum("personal");
        if (count($personal_existente) < $total_personal_requerido) {
            return response()->JSON([
                'sw' => false,
                'msj' => 'No es posible realizar la asignación debido a que la cantidad de personal actual no cubre el requerimiento de los puestos de vigilancias existentes',
            ]);
        }

        $nivel_alto = [
            'personal_min' => $request->cant_min_per_alto,
            'personal_max' => $request->cant_max_per_alto,
            'supervisor_min' => $request->cant_min_sup_alto,
            'guardia_min' => $request->cant_min_guar_alto,
            'guardia_max' => $request->cant_max_guar_alto,
        ];
        $nivel_medio = [
            'personal_min' => $request->cant_min_per_medio,
            'personal_max' => $request->cant_max_per_medio,
            'supervisor_min' => $request->cant_min_sup_medio,
            'guardia_min' => $request->cant_min_guar_medio,
            'guardia_max' => $request->cant_max_guar_medio,
        ];
        $nivel_basico = [
            'personal_min' => $request->cant_min_per_basico,
            'personal_max' => $request->cant_max_per_basico,
            'supervisor_min' => $request->cant_min_sup_basico,
            'guardia_min' => $request->cant_min_guar_basico,
            'guardia_max' => $request->cant_max_guar_basico,
        ];

        $h_experto = [
            'min' => $request->cant_min_experto,
            'max' => $request->cant_max_experto
        ];
        $h_moderado = [
            'min' => $request->cant_min_moderado,
            'max' => $request->cant_max_moderado
        ];
        $h_intermedio = [
            'min' => $request->cant_min_intermedio,
            'max' => $request->cant_max_intermedio
        ];
        $h_principiante = [
            'min' => $request->cant_min_principiante,
            'max' => $request->cant_max_principiante
        ];

        // VALIDAR LA CANTIDAD DE SUPERVISORES EXISTENTES DE ACUERDO AL REQUERIDO POR PUESTOS DE VIGILANCIA
        $cpv_alto = count(PuestoVigilancia::where("estado", "ACTIVO")->where("nivel", "ALTO")->get());
        $cpv_medio = count(PuestoVigilancia::where("estado", "ACTIVO")->where("nivel", "MEDIO")->get());
        $cpv_basico = count(PuestoVigilancia::where("estado", "ACTIVO")->where("nivel", "BAJO")->get());

        $total_sup_requeridos = (int)$cpv_alto * (int)$nivel_alto["supervisor_min"] + (int)$cpv_medio * (int)$nivel_medio["supervisor_min"] + (int)$cpv_basico * (int)$nivel_basico["supervisor_min"];

        $personal_existente = Personal::where('estado', 'ACTIVO')->where("tipo", "SUPERVISOR")->get();
        if (count($personal_existente) < $total_sup_requeridos) {
            return response()->JSON([
                'sw' => false,
                'msj' => 'No es posible realizar la asignación debido a que la cantidad de supervisores no es suficiente',
            ]);
        }

        ini_set('max_execution_time', 0);
        $resultado = AlgoritmoController::algoritmo($nivel_alto, $nivel_medio, $nivel_basico, $h_experto, $h_moderado, $h_intermedio, $h_principiante);
        sleep(2);
        return response()->JSON([
            'sw' => true,
            'msj' => 'La asignación se completó exitosamente',
            'resultado' => $resultado
        ]);
    }

    public function store(Request $request)
    {
        $resultado = $request;
        $fecha_registro = date('Y-m-d');
        $generacion = Generacion::where("fecha", $fecha_registro)->get()->first();
        if ($generacion) {
            // VACIAR ASIGNACIÓN ANTERIOR
            foreach ($generacion->asignacions as $value) {
                $value->asignacion_personals()->delete();
            }
            $generacion->asignacions()->delete();
        } else {
            $generacion = Generacion::create([
                "fecha" => $fecha_registro
            ]);
        }

        foreach ($resultado[1] as $res) {
            $nueva_asignacion = Asignacion::create([
                "generacion_id" => $generacion->id,
                'puesto_vigilancia_id' => $res[0]["id"],
                'fecha_registro' => $fecha_registro
            ]);
            foreach ($res[1]["supervisores"] as $p) {
                $personal = Personal::findOrFail($p);
                $nueva_asignacion->asignacion_personals()->create([
                    'personal_id' => $personal->id,
                    'tipo_personal' => $personal->tipo,
                ]);
            }
            foreach ($res[1]["guardias"] as $p) {
                $personal = Personal::findOrFail($p);
                $nueva_asignacion->asignacion_personals()->create([
                    'personal_id' => $personal->id,
                    'tipo_personal' => $personal->tipo,
                ]);
            }
        }

        return response()->JSON([
            'sw' => true,
            'msj' => 'La asignación se completó exitosamente',
            'generacion' => $generacion
        ]);
    }

    public function update(Asignacion $asignacion, Request $request)
    {
        // $this->validacion['codigo'] = 'required|min:1|unique:asignacions,codigo,' . $asignacion->id;
        // $request->validate($this->validacion);
        $asignacion->update(array_map('mb_strtoupper', $request->all()));
        return response()->JSON([
            'msj' => 'Actualización éxitosa',
            'asignacion' => $asignacion
        ]);
    }

    public function destroy(Asignacion $asignacion)
    {
        $asignacion->delete();
        return response()->JSON(['msj' => 'Registro eliminado']);
    }
}
