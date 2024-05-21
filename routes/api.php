<?php

use App\Http\Controllers\api\CitaController;
use App\Http\Controllers\API\FacturacionController;
use App\Http\Controllers\API\PacienteController;
use App\Http\Controllers\API\PersonalMedicoController;
use App\Http\Controllers\API\TratamientoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/citas', [CitaController::class, 'index'])->name('citas.index');
Route::post('/citas', [CitaController::class, 'store'])->name('citas.store');
Route::get('/citas/{id}', [CitaController::class, 'show'])->name('citas.show');
Route::get('/citas/{id}/edit', [CitaController::class, 'edit'])->name('citas.edit');
Route::put('/citas/{id}', [CitaController::class, 'update'])->name('citas.update');
Route::delete('/citas/{id}', [CitaController::class, 'destroy'])->name('citas.destroy');


Route::get('/pacientes', [PacienteController::class, 'index'])->name('pacientes.index');
Route::post('/pacientes', [PacienteController::class, 'store'])->name('pacientes.store');
Route::get('/pacientes/{id}', [PacienteController::class, 'show'])->name('pacientes.show');
Route::get('/pacientes/{id}/edit', [PacienteController::class, 'edit'])->name('pacientes.edit');
Route::put('/pacientes/{id}', [PacienteController::class, 'update'])->name('pacientes.update');
Route::delete('/pacientes/{id}', [PacienteController::class, 'destroy'])->name('pacientes.destroy');


Route::get('/facturas', [FacturacionController::class, 'index'])->name('facturas.index');
Route::post('/facturas', [FacturacionController::class, 'store'])->name('facturas.store');
Route::get('/facturas/{id}', [FacturacionController::class, 'show'])->name('facturas.show');
Route::get('/facturas/{id}/edit', [PacienteController::class, 'edit'])->name('facturas.edit');
Route::put('/facturas/{id}', [PacienteController::class, 'update'])->name('facturas.update');
Route::delete('/facturas/{id}', [PacienteController::class, 'destroy'])->name('facturas.destroy');



Route::get('/personal_medico', [PersonalMedicoController::class, 'index'])->name('personal_medico.index');
Route::post('/personal_medico', [PersonalMedicoController::class, 'store'])->name('personal_medico.store');
Route::get('/personal_medico/{id}', [PersonalMedicoController::class, 'show'])->name('personal_medico.show');
Route::get('/personal_medico/{id}/edit', [PersonalMedicoController::class, 'edit'])->name('personal_medico.edit');
Route::put('/personal_medico/{id}', [PersonalMedicoController::class, 'update'])->name('personal_medico.update');
Route::delete('/personal_medico/{id}', [PersonalMedicoController::class, 'destroy'])->name('personal_medico.destroy');



Route::get('/tratamiento', [TratamientoController::class, 'index'])->name('tratamiento.index');
Route::post('/tratamiento', [TratamientoController::class, 'store'])->name('tratamiento.store');
Route::get('/tratamiento/{id}', [TratamientoController::class, 'show'])->name('tratamiento.show');
Route::get('/tratamiento/{id}/edit', [TratamientoController::class, 'edit'])->name('tratamiento.edit');
Route::put('/tratamiento/{id}', [TratamientoController::class, 'update'])->name('tratamiento.update');
Route::delete('/tratamiento/{id}', [TratamientoController::class, 'destroy'])->name('tratamiento.destroy');



