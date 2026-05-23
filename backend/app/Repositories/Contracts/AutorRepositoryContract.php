<?php

namespace App\Repositories\Contracts;

use App\DTOs\AutorDTO;
use App\Models\Autor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface AutorRepositoryContract
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function findAll(): Collection;

    public function findById(int $id): Autor;

    public function create(AutorDTO $dto): Autor;

    public function update(int $id, AutorDTO $dto): Autor;

    public function delete(int $id): void;
}
