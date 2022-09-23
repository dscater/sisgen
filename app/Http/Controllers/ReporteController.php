<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Models\Asistencia;
use App\Models\Personal;
use App\Models\PuestoVigilancia;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;

class ReporteController extends Controller
{
    public function usuarios(Request $request)
    {
        $filtro =  $request->filtro;
        $usuarios = User::where('id', '!=', 1)->get();
        if ($filtro == 'Rango de fechas') {
            $request->validate([
                'fecha_ini' => 'required|date',
                'fecha_fin' => 'required|date',
            ]);
            $usuarios = User::where('id', '!=', 1)->whereBetween('fecha_registro', [$request->fecha_ini, $request->fecha_fin])->get();
        }

        if ($filtro == 'Tipo de usuario') {
            $request->validate([
                'tipo' => 'required|in:ADMINISTRADOR,SUPERVISOR',
            ]);
            $usuarios = User::where('id', '!=', 1)->where('tipo', $request->tipo)->get();
        }

        $pdf = PDF::loadView('reportes.usuarios', compact('usuarios'))->setPaper('legal', 'landscape');
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->download('Usuarios.pdf');
    }

    public function asignacions()
    {
        $asignacions = Asignacion::all();
        $pdf = PDF::loadView('reportes.asignacions', compact('asignacions'))->setPaper('legal', 'portrait');
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->download('Usuarios.pdf');
    }

    public function personal(Request $request)
    {
        $filtro =  $request->filtro;
        $personals = Personal::all();
        if ($filtro == 'Estado') {
            $request->validate([
                'estado' => 'required',
            ]);
            $personals = Personal::where('estado', $request->estado)->get();
        }

        if ($filtro == 'Tipo de personal') {
            $request->validate([
                'tipo' => 'required|in:SUPERVISOR,GUARDIA',
            ]);
            $personals = Personal::where('tipo', $request->tipo)->get();
        }

        $pdf = PDF::loadView('reportes.personal', compact('personals'))->setPaper('legal', 'landscape');
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->download('Personal.pdf');
    }
    public function puesto_vigilancias(Request $request)
    {
        $filtro =  $request->filtro;
        $puesto_vigilancias = PuestoVigilancia::all();
        if ($filtro == 'Puesto de Vigilancia') {
            $request->validate([
                'puesto_vigilancia_id' => 'required',
            ]);
            $puesto_vigilancias = PuestoVigilancia::where('id', $request->puesto_vigilancia_id)->get();
        }

        $pdf = PDF::loadView('reportes.puesto_vigilancias', compact('puesto_vigilancias'))->setPaper('legal', 'portrait');
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->download('Personal.pdf');
    }
    public function asistencias(Request $request)
    {
        $filtro =  $request->filtro;
        $asistencias = Asistencia::all();
        if ($filtro == 'Rango de fechas') {
            $request->validate([
                'fecha_ini' => 'required|date',
                'fecha_fin' => 'required|date',
            ]);
            $asistencias = Asistencia::whereBetween('fecha', [$request->fecha_ini, $request->fecha_fin])->get();
        }

        if ($filtro == 'Personal') {
            $request->validate([
                'personal' => 'required',
            ]);
            $asistencias = Asistencia::where('personal_id', $request->personal)->get();
        }

        $pdf = PDF::loadView('reportes.asistencias', compact('asistencias'))->setPaper('legal', 'portrait');
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->download('Asistencias.pdf');
    }
}
