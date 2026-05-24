<?php

namespace App\Repositories;

use App\DTOs\AutorDTO;
use App\Models\Autor;
use App\Repositories\Contracts\AutorRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class AutorRepository implements AutorRepositoryContract
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Autor::orderBy('nome')->paginate($perPage);
    }

    public function findAll(): Collection
    {
        return Autor::orderBy('nome')->get();
    }

    public function findById(int $id): Autor
    {
        return Autor::findOrFail($id);
    }

    public function create(AutorDTO $dto): Autor
    {
        return Autor::create(['nome' => $dto->nome]);
    }

    public function update(int $id, AutorDTO $dto): Autor
    {
        $autor = Autor::findOrFail($id);
        $autor->update(['nome' => $dto->nome]);

        return $autor->fresh();
    }

    public function delete(int $id): void
    {
        Autor::findOrFail($id)->delete();
    }
}
