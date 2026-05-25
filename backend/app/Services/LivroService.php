<?php

namespace App\Services;

use App\DTOs\LivroDTO;
use App\Models\Livro;
use App\Repositories\Contracts\LivroRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

readonly class LivroService
{
    public function __construct(
        private LivroRepositoryContract $repository,
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

    public function buscar(int $id): Livro
    {
        return $this->repository->findById($id);
    }

    public function criar(LivroDTO $dto): Livro
    {
        return $this->repository->create($dto);
    }

    public function atualizar(int $id, LivroDTO $dto): Livro
    {
        return $this->repository->update($id, $dto);
    }

    public function remover(int $id): void
    {
        $this->repository->delete($id);
    }
}
