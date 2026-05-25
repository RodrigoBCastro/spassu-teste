<?php

namespace App\Http\Controllers;

use App\DTOs\AutorDTO;
use App\Http\Requests\Autor\StoreAutorRequest;
use App\Http\Requests\Autor\UpdateAutorRequest;
use App\Http\Resources\AutorResource;
use App\Services\AutorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class AutorController extends Controller
{
    public function __construct(
        private readonly AutorService $service,
    ) {}

    #[OA\Get(path: '/autores', summary: 'Listar autores', tags: ['Autores'],
        responses: [new OA\Response(response: 200, description: 'Lista de autores',
            content: new OA\JsonContent(properties: [
                new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/Autor')),
            ])
        )]
    )]
    public function index(): AnonymousResourceCollection
    {
        return AutorResource::collection($this->service->listarTodos());
    }

    #[OA\Post(path: '/autores', summary: 'Criar autor', requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/AutorInput')),
        tags: ['Autores'],
        responses: [
            new OA\Response(response: 201, description: 'Autor criado',
                content: new OA\JsonContent(properties: [new OA\Property(property: 'data', ref: '#/components/schemas/Autor')])),
            new OA\Response(response: 422, description: 'Erro de validação'),
        ]
    )]
    public function store(StoreAutorRequest $request): JsonResponse
    {
        $autor = $this->service->criar(AutorDTO::fromArray($request->validated()));

        return new AutorResource($autor)
            ->response()
            ->setStatusCode(201);
    }

    #[OA\Get(path: '/autores/{id}', summary: 'Buscar autor', tags: ['Autores'],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Autor encontrado',
                content: new OA\JsonContent(properties: [new OA\Property(property: 'data', ref: '#/components/schemas/Autor')])),
            new OA\Response(response: 404, description: 'Não encontrado'),
        ]
    )]
    public function show(int $id): AutorResource
    {
        return new AutorResource($this->service->buscar($id));
    }

    #[OA\Put(path: '/autores/{id}', summary: 'Atualizar autor', requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/AutorInput')),
        tags: ['Autores'],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Autor atualizado',
                content: new OA\JsonContent(properties: [new OA\Property(property: 'data', ref: '#/components/schemas/Autor')])),
            new OA\Response(response: 404, description: 'Não encontrado'),
            new OA\Response(response: 422, description: 'Erro de validação'),
        ]
    )]
    public function update(UpdateAutorRequest $request, int $id): AutorResource
    {
        return new AutorResource(
            $this->service->atualizar($id, AutorDTO::fromArray($request->validated()))
        );
    }

    #[OA\Delete(path: '/autores/{id}', summary: 'Remover autor', tags: ['Autores'],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 204, description: 'Removido'),
            new OA\Response(response: 404, description: 'Não encontrado'),
            new OA\Response(response: 422, description: 'Autor vinculado a livros'),
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        $this->service->remover($id);

        return response()->json(null, 204);
    }
}
