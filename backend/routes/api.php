<?php

use App\Http\Controllers\AssuntoController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\RelatorioController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    Route::get('autores/todos', [AutorController::class, 'todos']);
    Route::get('assuntos/todos', [AssuntoController::class, 'todos']);
    Route::get('livros/todos', [LivroController::class, 'todos']);

    Route::apiResource('autores', AutorController::class);
    Route::apiResource('assuntos', AssuntoController::class);
    Route::apiResource('livros', LivroController::class);

    Route::get('relatorio/livros-por-autor', [RelatorioController::class, 'livrosPorAutor']);
});
