<?php

namespace App\Http\Controllers;

use App\DTOs\LivroDTO;
use App\Http\Requests\Livro\StoreLivroRequest;
use App\Http\Requests\Livro\UpdateLivroRequest;
use App\Http\Resources\LivroResource;
use App\Services\LivroService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LivroController extends Controller
{
    public function __construct(
        private readonly LivroService $service,
    ) {}

    public function index(): AnonymousResourceCollection
    {
        return LivroResource::collection($this->service->listar());
    }

    public function store(StoreLivroRequest $request): JsonResponse
    {
        $livro = $this->service->criar(LivroDTO::fromArray($request->validated()));

        return new LivroResource($livro)
            ->response()
            ->setStatusCode(201);
    }

    public function show(int $id): LivroResource
    {
        return new LivroResource($this->service->buscar($id));
    }

    public function update(UpdateLivroRequest $request, int $id): LivroResource
    {
        return new LivroResource(
            $this->service->atualizar($id, LivroDTO::fromArray($request->validated()))
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service->remover($id);

        return response()->json(null, 204);
    }
}
