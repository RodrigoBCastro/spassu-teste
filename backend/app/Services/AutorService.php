<?php

namespace App\Services;

use App\DTOs\AutorDTO;
use App\Models\Autor;
use App\Repositories\Contracts\AutorRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

readonly class AutorService
{
    public function __construct(
        private AutorRepositoryContract $repository,
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

    public function buscar(int $id): Autor
    {
        return $this->repository->findById($id);
    }

    public function criar(AutorDTO $dto): Autor
    {
        return $this->repository->create($dto);
    }

    public function atualizar(int $id, AutorDTO $dto): Autor
    {
        return $this->repository->update($id, $dto);
    }

    public function remover(int $id): void
    {
        $autor = $this->repository->findById($id);

        if ($autor->livros()->exists()) {
            abort(422, 'Não é possível remover um autor vinculado a livros.');
        }

        $this->repository->delete($id);
    }
}
