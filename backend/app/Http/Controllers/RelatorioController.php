<?php

namespace App\Http\Controllers;

use App\Services\RelatorioService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class RelatorioController extends Controller
{
    public function __construct(
        private readonly RelatorioService $service,
    ) {}

    #[OA\Get(path: '/relatorio/livros-por-autor', summary: 'Livros agrupados por autor', tags: ['Relatório'],
        responses: [new OA\Response(response: 200, description: 'Relatório gerado com sucesso',
            content: new OA\JsonContent(properties: [
                new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/RelatorioAutor')),
            ])
        )]
    )]
    public function livrosPorAutor(): JsonResponse
    {
        return response()->json([
            'data' => $this->service->livrosPorAutor(),
        ]);
    }
}
