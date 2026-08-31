<?php

use App\Http\Controllers\ContratoPublicoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('contratos.index');
});

// Rutas públicas de contratos (sin autenticación)
Route::get('/contratos', [ContratoPublicoController::class, 'index'])->name('contratos.index');
Route::get('/contratos/{contrato}', [ContratoPublicoController::class, 'show'])->name('contratos.show');
Route::get('/contratos/{contrato}/descargar', [ContratoPublicoController::class, 'downloadContrato'])->name('contratos.download');
Route::get('/suplementos/{suplemento}/descargar', [ContratoPublicoController::class, 'downloadSuplemento'])->name('suplementos.download');
