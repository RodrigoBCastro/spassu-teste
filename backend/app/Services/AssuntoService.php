<?php

namespace App\Services;

use App\DTOs\AssuntoDTO;
use App\Models\Assunto;
use App\Repositories\Contracts\AssuntoRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

readonly class AssuntoService
{
    public function __construct(
        private AssuntoRepositoryContract $repository,
    ) {}

    public function listar(): LengthAwarePaginator
    {
        $perPage = request()->integer('per_page', 15);
        return $this->repository->paginate($perPage);
    }

    public function listarTodos(): Collection
    {
        return $this->repository->findAll();
    }

    public function buscar(int $id): Assunto
    {
        return $this->repository->findById($id);
    }

    public function criar(AssuntoDTO $dto): Assunto
    {
        return $this->repository->create($dto);
    }

    public function atualizar(int $id, AssuntoDTO $dto): Assunto
    {
        return $this->repository->update($id, $dto);
    }

    public function remover(int $id): void
    {
        $assunto = $this->repository->findById($id);

        if ($assunto->livros()->exists()) {
            abort(422, 'Não é possível remover um assunto vinculado a livros.');
        }

        $this->repository->delete($id);
    }
}
