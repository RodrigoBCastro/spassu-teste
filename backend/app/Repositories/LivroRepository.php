<?php

namespace App\Repositories;

use App\DTOs\LivroDTO;
use App\Models\Livro;
use App\Repositories\Contracts\LivroRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class LivroRepository implements LivroRepositoryContract
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Livro::with(['autores', 'assuntos'])
            ->orderBy('titulo')
            ->paginate($perPage);
    }

    public function findById(int $id): Livro
    {
        return Livro::with(['autores', 'assuntos'])->findOrFail($id);
    }

    public function create(LivroDTO $dto): Livro
    {
        return DB::transaction(function () use ($dto): Livro {
            $livro = Livro::create([
                'titulo' => $dto->titulo,
                'editora' => $dto->editora,
                'edicao' => $dto->edicao,
                'ano_publicacao' => $dto->anoPublicacao,
                'valor' => $dto->valor,
            ]);

            $livro->autores()->sync($dto->autoresIds);
            $livro->assuntos()->sync($dto->assuntosIds);

            return $livro->load(['autores', 'assuntos']);
        });
    }

    public function update(int $id, LivroDTO $dto): Livro
    {
        return DB::transaction(function () use ($id, $dto): Livro {
            $livro = Livro::findOrFail($id);

            $livro->update([
                'titulo' => $dto->titulo,
                'editora' => $dto->editora,
                'edicao' => $dto->edicao,
                'ano_publicacao' => $dto->anoPublicacao,
                'valor' => $dto->valor,
            ]);

            $livro->autores()->sync($dto->autoresIds);
            $livro->assuntos()->sync($dto->assuntosIds);

            return $livro->load(['autores', 'assuntos']);
        });
    }

    public function delete(int $id): void
    {
        Livro::findOrFail($id)->delete();
    }
}
