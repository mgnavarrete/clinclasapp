<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\SesionController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\EspecialistaController;
use App\Http\Controllers\PEController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\ReunionController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\PagoController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// AUTHENTICATION //
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('index');
    }
    return view('pages.inicio');
})->name('inicio');  // Redirige a 'index' si el usuario está autenticado, de lo contrario muestra 'inicio'

// // LOGIN //
Route::post('/registrar', [LoginController::class, 'registrar'])->name('registrar');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('index', [IndexController::class, 'index'])->name('index');
    Route::put('/sesiones/{id}/actualizar', [IndexController::class, 'actualizarEstadoSesion'])->name('actualizarEstadoSesion');
    Route::get('/pacientes', [PacienteController::class, 'index'])->name('pacientes.index');
    Route::get('/pacientes/form', [PacienteController::class, 'form'])->name('pacientes.form');
    Route::post('/pacientes/create', [PacienteController::class, 'create'])->name('pacientes.create');
    Route::get('/pacientes/{id}', [PacienteController::class, 'show'])->name('pacientes.show');
    Route::post('/pacientes/{id}/update', [PacienteController::class, 'update'])->name('pacientes.update');
    Route::post('/sesiones/{id}/update', [SesionController::class, 'update'])->name('sesiones.update');
    Route::post('/tutores/{id}/update', [TutorController::class, 'update'])->name('tutores.update');
    Route::post('/tutores/{id}/create', [TutorController::class, 'create'])->name('tutores.create');
    Route::post('/especialistas/{id}/create', [EspecialistaController::class, 'create'])->name('especialistas.create');
    Route::post('/PE/{id}/create', [PEController::class, 'create'])->name('PE.create');
    Route::post('/estado/{id}/update', [EstadoController::class, 'update'])->name('estado.update');
    Route::post('/estado/{id}/create', [EstadoController::class, 'create'])->name('estado.create');
    Route::post('/reuniones/{id}/update', [ReunionController::class, 'update'])->name('reuniones.update');
    Route::post('/reuniones/{id}/create', [ReunionController::class, 'create'])->name('reuniones.create');
    Route::post('/calendario/createReunion', [CalendarioController::class, 'createReunion'])->name('calendario.createReunion');
    Route::post('/calendario/createSesion', [CalendarioController::class, 'createSesion'])->name('calendario.createSesion');
    Route::get('/calendario', [CalendarioController::class, 'index'])->name('calendario.index');
    Route::post('/estado/{id}/updateCal', [EstadoController::class, 'updateCal'])->name('estado.updateCal');
    Route::post('/reuniones/{id}/updateCal', [ReunionController::class, 'updateCal'])->name('reuniones.updateCal');
    Route::post('/estado/{id}/updateIdx', [EstadoController::class, 'updateIdx'])->name('estado.updateIdx');
    Route::post('/reuniones/{id}/updateIdx', [ReunionController::class, 'updateIdx'])->name('reuniones.updateIdx');
    Route::get('/pagos', [PagoController::class, 'index'])->name('pagos.index');
    Route::post('/pago/{id}/update', [PagoController::class, 'update'])->name('pago.update');
    Route::post('/pago/{id}/updatePac', [PagoController::class, 'updatePac'])->name('pago.updatePac');
    Route::post('/pago/create', [PagoController::class, 'create'])->name('pago.create');
    Route::get('/pagos/{id}', [PagoController::class, 'show'])->name('pagos.show');
    Route::post('/pago/{id}/updateShow', [PagoController::class, 'updateShow'])->name('pago.updateShow');

    Route::get('/pagos/{id}/descargar', [PagoController::class, 'descargarPDF'])->name('pagos.descargar');
    Route::get('/pdf/{id}/pago', [PagoController::class, 'pagePDF'])->name('pdf.pago');
});
