<?php

namespace App\Services;

use App\DTOs\LivroDTO;
use App\Models\Livro;
use App\Repositories\Contracts\LivroRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

readonly class LivroService
{
    public function __construct(
        private LivroRepositoryContract $repository,
    ) {}

    public function listar(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage);
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
