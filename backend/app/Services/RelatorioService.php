<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

readonly class RelatorioService
{
    public function livrosPorAutor(): Collection
    {
        $rows = DB::table('vw_relatorio_livros_por_autor')->get();

        return $rows->groupBy('cod_au')->map(function ($livros, int $codAu): array {
            $primeiro = $livros->first();

            return [
                'cod_au' => $codAu,
                'autor_nome' => $primeiro->autor_nome,
                'livros' => $livros->map(fn ($row): array => [
                    'cod_l' => $row->cod_l,
                    'titulo' => $row->titulo,
                    'editora' => $row->editora,
                    'edicao' => $row->edicao,
                    'ano_publicacao' => $row->ano_publicacao,
                    'valor' => $row->valor,
                    'assuntos' => $row->assuntos,
                ])->values()->all(),
            ];
        })->values();
    }
}
