<?php

namespace App\Http\Controllers;

use App\DTOs\AutorDTO;
use App\Http\Requests\Autor\StoreAutorRequest;
use App\Http\Requests\Autor\UpdateAutorRequest;
use App\Http\Resources\AutorResource;
use App\Services\AutorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AutorController extends Controller
{
    public function __construct(
        private readonly AutorService $service,
    ) {}

    public function index(): AnonymousResourceCollection
    {
        return AutorResource::collection($this->service->listarTodos());
    }

    public function store(StoreAutorRequest $request): JsonResponse
    {
        $autor = $this->service->criar(AutorDTO::fromArray($request->validated()));

        return new AutorResource($autor)
            ->response()
            ->setStatusCode(201);
    }

    public function show(int $id): AutorResource
    {
        return new AutorResource($this->service->buscar($id));
    }

    public function update(UpdateAutorRequest $request, int $id): AutorResource
    {
        return new AutorResource(
            $this->service->atualizar($id, AutorDTO::fromArray($request->validated()))
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service->remover($id);

        return response()->json(null, 204);
    }
}
