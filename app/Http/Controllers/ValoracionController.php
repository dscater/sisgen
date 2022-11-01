<?php

namespace App\Http\Controllers;

use App\Models\ValoracionPersonal;
use App\Models\ValoracionPuesto;
use Illuminate\Http\Request;

class ValoracionController extends Controller
{
    public function getValoraciones()
    {
        $valoracion_puestos = ValoracionPuesto::first();
        $valoracion_personal = ValoracionPersonal::first();

        if ($valoracion_puestos) {
            $cant_min_per_alto = $valoracion_puestos->cant_min_per_alto;
            $cant_max_per_alto = $valoracion_puestos->cant_max_per_alto;
            $cant_min_sup_alto = $valoracion_puestos->cant_min_sup_alto;
            $cant_min_guar_alto = $valoracion_puestos->cant_min_guar_alto;
            $cant_max_guar_alto = $valoracion_puestos->cant_max_guar_alto;
            $cant_min_per_medio = $valoracion_puestos->cant_min_per_medio;
            $cant_max_per_medio = $valoracion_puestos->cant_max_per_medio;
            $cant_min_sup_medio = $valoracion_puestos->cant_min_sup_medio;
            $cant_min_guar_medio = $valoracion_puestos->cant_min_guar_medio;
            $cant_max_guar_medio = $valoracion_puestos->cant_max_guar_medio;
            $cant_min_per_basico = $valoracion_puestos->cant_min_per_basico;
            $cant_max_per_basico = $valoracion_puestos->cant_max_per_basico;
            $cant_min_sup_basico = $valoracion_puestos->cant_min_sup_basico;
            $cant_min_guar_basico = $valoracion_puestos->cant_min_guar_basico;
            $cant_max_guar_basico = $valoracion_puestos->cant_max_guar_basico;
        } else {
            $cant_min_per_alto = 11;
            $cant_max_per_alto = 15;
            $cant_min_sup_alto = 4;
            $cant_min_guar_alto = 7;
            $cant_max_guar_alto = 11;
            $cant_min_per_medio = 7;
            $cant_max_per_medio = 10;
            $cant_min_sup_medio = 3;
            $cant_min_guar_medio = 4;
            $cant_max_guar_medio = 7;
            $cant_min_per_basico = 4;
            $cant_max_per_basico = 6;
            $cant_min_sup_basico = 2;
            $cant_min_guar_basico = 2;
            $cant_max_guar_basico = 4;
        }

        if ($valoracion_personal) {
            $cant_min_experto = $valoracion_personal->cant_min_experto;
            $cant_max_experto = $valoracion_personal->cant_max_experto;
            $cant_min_moderado = $valoracion_personal->cant_min_moderado;
            $cant_max_moderado = $valoracion_personal->cant_max_moderado;
            $cant_min_intermedio = $valoracion_personal->cant_min_intermedio;
            $cant_max_intermedio = $valoracion_personal->cant_max_intermedio;
            $cant_min_principiante = $valoracion_personal->cant_min_principiante;
            $cant_max_principiante = $valoracion_personal->cant_max_principiante;
        } else {
            $cant_min_experto = 12;
            $cant_max_experto = 15;
            $cant_min_moderado = 8;
            $cant_max_moderado = 11;
            $cant_min_intermedio = 4;
            $cant_max_intermedio = 7;
            $cant_min_principiante = 1;
            $cant_max_principiante = 3;
        }

        return response()->JSON([
            "cant_min_per_alto" => $cant_min_per_alto,
            "cant_max_per_alto" => $cant_max_per_alto,
            "cant_min_sup_alto" => $cant_min_sup_alto,
            "cant_min_guar_alto" => $cant_min_guar_alto,
            "cant_max_guar_alto" => $cant_max_guar_alto,
            "cant_min_per_medio" => $cant_min_per_medio,
            "cant_max_per_medio" => $cant_max_per_medio,
            "cant_min_sup_medio" => $cant_min_sup_medio,
            "cant_min_guar_medio" => $cant_min_guar_medio,
            "cant_max_guar_medio" => $cant_max_guar_medio,
            "cant_min_per_basico" => $cant_min_per_basico,
            "cant_max_per_basico" => $cant_max_per_basico,
            "cant_min_sup_basico" => $cant_min_sup_basico,
            "cant_min_guar_basico" => $cant_min_guar_basico,
            "cant_max_guar_basico" => $cant_max_guar_basico,
            "cant_min_experto" => $cant_min_experto,
            "cant_max_experto" => $cant_max_experto,
            "cant_min_moderado" => $cant_min_moderado,
            "cant_max_moderado" => $cant_max_moderado,
            "cant_min_intermedio" => $cant_min_intermedio,
            "cant_max_intermedio" => $cant_max_intermedio,
            "cant_min_principiante" => $cant_min_principiante,
            "cant_max_principiante" => $cant_max_principiante,
        ]);
    }

    public function actualizaValoracionPuesto(Request $request)
    {
        $valoracion_puestos = ValoracionPuesto::first();
        if ($valoracion_puestos) {
            $valoracion_puestos[$request->key] = $request->valor;
            $valoracion_puestos->save();
        }
        return response()->JSON(true);
    }

    public function actualizaValoracionPersonal(Request $request)
    {
        $valoracion_personal = ValoracionPersonal::first();
        if ($valoracion_personal) {
            $valoracion_personal[$request->key] = $request->valor;
            $valoracion_personal->save();
        }
        return response()->JSON(true);
    }
}
