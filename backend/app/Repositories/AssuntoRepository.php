<?php

namespace App\Repositories;

use App\DTOs\AssuntoDTO;
use App\Models\Assunto;
use App\Repositories\Contracts\AssuntoRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class AssuntoRepository implements AssuntoRepositoryContract
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Assunto::orderBy('descricao')->paginate($perPage);
    }

    public function findAll(): Collection
    {
        return Assunto::orderBy('descricao')->get();
    }

    public function findById(int $id): Assunto
    {
        return Assunto::findOrFail($id);
    }

    public function create(AssuntoDTO $dto): Assunto
    {
        return Assunto::create(['descricao' => $dto->descricao]);
    }

    public function update(int $id, AssuntoDTO $dto): Assunto
    {
        $assunto = Assunto::findOrFail($id);
        $assunto->update(['descricao' => $dto->descricao]);

        return $assunto->fresh();
    }

    public function delete(int $id): void
    {
        Assunto::findOrFail($id)->delete();
    }
}
