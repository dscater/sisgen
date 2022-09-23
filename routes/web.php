<?php

use App\Http\Controllers\AsignacionController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\PuestoVigilanciaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// LOGIN
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);

// CONFIGURACIÓN
Route::get('/configuracion/getConfiguracion', [ConfiguracionController::class, 'getConfiguracion']);
Route::post('/configuracion/update', [ConfiguracionController::class, 'update']);


Route::prefix('admin')->group(function () {
    // USUARIOS
    Route::get('usuarios/getUsuario/{usuario}', [UserController::class, 'getUsuario']);
    Route::get('usuarios/userActual', [UserController::class, 'userActual']);
    Route::get('usuarios/getInfoBox', [UserController::class, 'getInfoBox']);
    Route::get('usuarios/getPermisos/{usuario}', [UserController::class, 'getPermisos']);
    Route::get('usuarios/getEncargadosRepresentantes', [UserController::class, 'getEncargadosRepresentantes']);
    Route::post('usuarios/actualizaContrasenia/{usuario}', [UserController::class, 'actualizaContrasenia']);
    Route::post('usuarios/actualizaFoto/{usuario}', [UserController::class, 'actualizaFoto']);
    Route::resource('usuarios', UserController::class)->only([
        'index', 'store', 'update', 'destroy', 'show'
    ]);

    // PERSONAL
    Route::resource('personals', PersonalController::class)->only([
        'index', 'store', 'update', 'destroy', 'show'
    ]);

    // PUESTOS DE VIGILANCIA
    Route::get('puesto_vigilancias/getLista', [PuestoVigilanciaController::class, 'getLista']);
    Route::resource('puesto_vigilancias', PuestoVigilanciaController::class)->only([
        'index', 'store', 'update', 'destroy', 'show'
    ]);

    // MATERIALES
    Route::resource('materials', MaterialController::class)->only([
        'index', 'store', 'update', 'destroy', 'show'
    ]);

    // ASIGNACIÓN DE PERSONAL
    Route::resource('asignacions', AsignacionController::class)->only([
        'index', 'store', 'update', 'destroy', 'show'
    ]);

    // ASISTENCIAS
    Route::get('asistencias/getTipo', [AsistenciaController::class, 'getTipo']);
    Route::resource('asistencias', AsistenciaController::class)->only([
        'index', 'store', 'update', 'destroy', 'show'
    ]);

    // REPORTES
    Route::post('reportes/usuarios', [ReporteController::class, 'usuarios']);

    Route::post('reportes/asignacions', [ReporteController::class, 'asignacions']);

    Route::post('reportes/personal', [ReporteController::class, 'personal']);

    Route::post('reportes/puesto_vigilancias', [ReporteController::class, 'puesto_vigilancias']);

    Route::post('reportes/asistencias', [ReporteController::class, 'asistencias']);
});

// ---------------------------------------
Route::get('/{optional?}', function () {
    return view('app');
})->name('base_path')->where('optional', '.*');
