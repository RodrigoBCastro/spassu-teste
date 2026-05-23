<?php

namespace App\Http\Controllers;

use App\DTOs\AssuntoDTO;
use App\Http\Requests\Assunto\StoreAssuntoRequest;
use App\Http\Requests\Assunto\UpdateAssuntoRequest;
use App\Http\Resources\AssuntoResource;
use App\Services\AssuntoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AssuntoController extends Controller
{
    public function __construct(
        private readonly AssuntoService $service,
    ) {}

    public function index(): AnonymousResourceCollection
    {
        return AssuntoResource::collection($this->service->listarTodos());
    }

    public function store(StoreAssuntoRequest $request): JsonResponse
    {
        $assunto = $this->service->criar(AssuntoDTO::fromArray($request->validated()));

        return new AssuntoResource($assunto)
            ->response()
            ->setStatusCode(201);
    }

    public function show(int $id): AssuntoResource
    {
        return new AssuntoResource($this->service->buscar($id));
    }

    public function update(UpdateAssuntoRequest $request, int $id): AssuntoResource
    {
        return new AssuntoResource(
            $this->service->atualizar($id, AssuntoDTO::fromArray($request->validated()))
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service->remover($id);

        return response()->json(null, 204);
    }
}
