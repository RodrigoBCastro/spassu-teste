<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            CREATE VIEW vw_relatorio_livros_por_autor AS
            SELECT
                a.cod_au,
                a.nome AS autor_nome,
                l.cod_l,
                l.titulo,
                l.editora,
                l.edicao,
                l.ano_publicacao,
                l.valor,
                COALESCE(
                    STRING_AGG(DISTINCT ass.descricao, ', ' ORDER BY ass.descricao),
                    ''
                ) AS assuntos
            FROM autores a
            JOIN livro_autor la ON la.autor_cod_au = a.cod_au
            JOIN livros l ON l.cod_l = la.livro_cod_l
            LEFT JOIN livro_assunto las ON las.livro_cod_l = l.cod_l
            LEFT JOIN assuntos ass ON ass.cod_as = las.assunto_cod_as
            GROUP BY a.cod_au, a.nome, l.cod_l, l.titulo, l.editora, l.edicao, l.ano_publicacao, l.valor
            ORDER BY a.nome, l.titulo
        ");
    }

    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS vw_relatorio_livros_por_autor');
    }
};
