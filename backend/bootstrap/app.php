<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ModelNotFoundException $e, Request $request): \Illuminate\Http\JsonResponse {
            return response()->json(
                ['message' => 'Registro não encontrado.'],
                404,
            );
        });

        $exceptions->render(function (QueryException $e, Request $request): \Illuminate\Http\JsonResponse {
            return match ($e->getCode()) {
                '23505' => response()->json(
                    ['message' => 'Já existe um registro com esses dados.'],
                    409,
                ),
                '23503' => response()->json(
                    ['message' => 'Não é possível excluir: registro referenciado por outros dados.'],
                    422,
                ),
                default => response()->json(
                    ['message' => 'Erro interno no banco de dados.'],
                    500,
                ),
            };
        });
    })->create();
