<?php

use App\Http\Controllers\AssuntoController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\LivroController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    Route::apiResource('autores', AutorController::class);
    Route::apiResource('assuntos', AssuntoController::class);
    Route::apiResource('livros', LivroController::class);
});
