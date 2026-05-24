<?php

namespace App\Repositories\Contracts;

use App\DTOs\AssuntoDTO;
use App\Models\Assunto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface AssuntoRepositoryContract
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function findAll(): Collection;

    public function findById(int $id): Assunto;

    public function create(AssuntoDTO $dto): Assunto;

    public function update(int $id, AssuntoDTO $dto): Assunto;

    public function delete(int $id): void;
}
