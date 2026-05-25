<?php

namespace App\Http\Controllers;

use App\DTOs\LivroDTO;
use App\Http\Requests\Livro\StoreLivroRequest;
use App\Http\Requests\Livro\UpdateLivroRequest;
use App\Http\Resources\LivroResource;
use App\Services\LivroService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class LivroController extends Controller
{
    public function __construct(
        private readonly LivroService $service,
    ) {}

    #[OA\Get(path: '/livros', summary: 'Listar livros', tags: ['Livros'],
        responses: [new OA\Response(response: 200, description: 'Lista de livros',
            content: new OA\JsonContent(properties: [
                new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/Livro')),
            ])
        )]
    )]
    public function index(): AnonymousResourceCollection
    {
        return LivroResource::collection($this->service->listar());
    }

    #[OA\Post(path: '/livros', summary: 'Criar livro', requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/LivroInput')),
        tags: ['Livros'],
        responses: [
            new OA\Response(response: 201, description: 'Livro criado',
                content: new OA\JsonContent(properties: [new OA\Property(property: 'data', ref: '#/components/schemas/Livro')])),
            new OA\Response(response: 422, description: 'Erro de validação'),
        ]
    )]
    public function store(StoreLivroRequest $request): JsonResponse
    {
        $livro = $this->service->criar(LivroDTO::fromArray($request->validated()));

        return new LivroResource($livro)
            ->response()
            ->setStatusCode(201);
    }

    #[OA\Get(path: '/livros/{id}', summary: 'Buscar livro', tags: ['Livros'],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Livro encontrado',
                content: new OA\JsonContent(properties: [new OA\Property(property: 'data', ref: '#/components/schemas/Livro')])),
            new OA\Response(response: 404, description: 'Não encontrado'),
        ]
    )]
    public function show(int $id): LivroResource
    {
        return new LivroResource($this->service->buscar($id));
    }

    #[OA\Put(path: '/livros/{id}', summary: 'Atualizar livro', requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/LivroInput')),
        tags: ['Livros'],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Livro atualizado',
                content: new OA\JsonContent(properties: [new OA\Property(property: 'data', ref: '#/components/schemas/Livro')])),
            new OA\Response(response: 404, description: 'Não encontrado'),
            new OA\Response(response: 422, description: 'Erro de validação'),
        ]
    )]
    public function update(UpdateLivroRequest $request, int $id): LivroResource
    {
        return new LivroResource(
            $this->service->atualizar($id, LivroDTO::fromArray($request->validated()))
        );
    }

    #[OA\Delete(path: '/livros/{id}', summary: 'Remover livro', tags: ['Livros'],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 204, description: 'Removido'),
            new OA\Response(response: 404, description: 'Não encontrado'),
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        $this->service->remover($id);

        return response()->json(null, 204);
    }
}
