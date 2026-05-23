<?php

namespace App\Repositories\Contracts;

use App\DTOs\LivroDTO;
use App\Models\Livro;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface LivroRepositoryContract
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function findById(int $id): Livro;

    public function create(LivroDTO $dto): Livro;

    public function update(int $id, LivroDTO $dto): Livro;

    public function delete(int $id): void;
}
