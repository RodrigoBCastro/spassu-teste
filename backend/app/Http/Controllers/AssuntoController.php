<?php

namespace App\Http\Controllers;

use App\DTOs\AssuntoDTO;
use App\Http\Requests\Assunto\StoreAssuntoRequest;
use App\Http\Requests\Assunto\UpdateAssuntoRequest;
use App\Http\Resources\AssuntoResource;
use App\Services\AssuntoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class AssuntoController extends Controller
{
    public function __construct(
        private readonly AssuntoService $service,
    ) {}

    #[OA\Get(path: '/assuntos', summary: 'Listar assuntos', tags: ['Assuntos'],
        responses: [new OA\Response(response: 200, description: 'Lista de assuntos',
            content: new OA\JsonContent(properties: [
                new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/Assunto')),
            ])
        )]
    )]
    public function index(): AnonymousResourceCollection
    {
        return AssuntoResource::collection($this->service->listarTodos());
    }

    #[OA\Post(path: '/assuntos', summary: 'Criar assunto', requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/AssuntoInput')),
        tags: ['Assuntos'],
        responses: [
            new OA\Response(response: 201, description: 'Assunto criado',
                content: new OA\JsonContent(properties: [new OA\Property(property: 'data', ref: '#/components/schemas/Assunto')])),
            new OA\Response(response: 422, description: 'Erro de validação'),
        ]
    )]
    public function store(StoreAssuntoRequest $request): JsonResponse
    {
        $assunto = $this->service->criar(AssuntoDTO::fromArray($request->validated()));

        return new AssuntoResource($assunto)
            ->response()
            ->setStatusCode(201);
    }

    #[OA\Get(path: '/assuntos/{id}', summary: 'Buscar assunto', tags: ['Assuntos'],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Assunto encontrado',
                content: new OA\JsonContent(properties: [new OA\Property(property: 'data', ref: '#/components/schemas/Assunto')])),
            new OA\Response(response: 404, description: 'Não encontrado'),
        ]
    )]
    public function show(int $id): AssuntoResource
    {
        return new AssuntoResource($this->service->buscar($id));
    }

    #[OA\Put(path: '/assuntos/{id}', summary: 'Atualizar assunto', requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/AssuntoInput')),
        tags: ['Assuntos'],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Assunto atualizado',
                content: new OA\JsonContent(properties: [new OA\Property(property: 'data', ref: '#/components/schemas/Assunto')])),
            new OA\Response(response: 404, description: 'Não encontrado'),
            new OA\Response(response: 422, description: 'Erro de validação'),
        ]
    )]
    public function update(UpdateAssuntoRequest $request, int $id): AssuntoResource
    {
        return new AssuntoResource(
            $this->service->atualizar($id, AssuntoDTO::fromArray($request->validated()))
        );
    }

    #[OA\Delete(path: '/assuntos/{id}', summary: 'Remover assunto', tags: ['Assuntos'],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 204, description: 'Removido'),
            new OA\Response(response: 404, description: 'Não encontrado'),
            new OA\Response(response: 422, description: 'Assunto vinculado a livros'),
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        $this->service->remover($id);

        return response()->json(null, 204);
    }
}
