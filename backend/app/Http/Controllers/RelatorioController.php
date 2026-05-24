<?php

namespace App\Http\Controllers;

use App\Services\RelatorioService;
use Illuminate\Http\JsonResponse;

class RelatorioController extends Controller
{
    public function __construct(
        private readonly RelatorioService $service,
    ) {}

    public function livrosPorAutor(): JsonResponse
    {
        return response()->json([
            'data' => $this->service->livrosPorAutor(),
        ]);
    }
}
