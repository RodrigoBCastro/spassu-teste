<?php

namespace Database\Seeders;

use App\Models\Assunto;
use App\Models\Autor;
use App\Models\Livro;
use Illuminate\Database\Seeder;

class LivroSeeder extends Seeder
{
    public function run(): void
    {
        $livros = [
            [
                'titulo'         => 'Dom Casmurro',
                'editora'        => 'Editora Ática',
                'edicao'         => 2,
                'ano_publicacao' => '1899',
                'valor'          => 45.90,
                'autores'        => ['Machado de Assis'],
                'assuntos'       => ['Literatura Brasileira', 'Romance', 'Clássico'],
            ],
            [
                'titulo'         => 'A Hora da Estrela',
                'editora'        => 'Rocco',
                'edicao'         => 1,
                'ano_publicacao' => '1977',
                'valor'          => 39.90,
                'autores'        => ['Clarice Lispector'],
                'assuntos'       => ['Literatura Brasileira', 'Romance'],
            ],
            [
                'titulo'         => 'O Alquimista',
                'editora'        => 'HarperCollins',
                'edicao'         => 1,
                'ano_publicacao' => '1988',
                'valor'          => 42.00,
                'autores'        => ['Paulo Coelho'],
                'assuntos'       => ['Ficção', 'Autoajuda'],
            ],
            [
                'titulo'         => 'Gabriela Cravo e Canela',
                'editora'        => 'Companhia das Letras',
                'edicao'         => 3,
                'ano_publicacao' => '1958',
                'valor'          => 55.00,
                'autores'        => ['Jorge Amado'],
                'assuntos'       => ['Literatura Brasileira', 'Romance'],
            ],
            [
                'titulo'         => 'Grande Sertão Veredas',
                'editora'        => 'Nova Fronteira',
                'edicao'         => 1,
                'ano_publicacao' => '1956',
                'valor'          => 62.50,
                'autores'        => ['Guimarães Rosa'],
                'assuntos'       => ['Literatura Brasileira', 'Ficção', 'Clássico'],
            ],
        ];

        foreach ($livros as $dados) {
            $livro = Livro::firstOrCreate(
                ['titulo' => $dados['titulo']],
                [
                    'editora'        => $dados['editora'],
                    'edicao'         => $dados['edicao'],
                    'ano_publicacao' => $dados['ano_publicacao'],
                    'valor'          => $dados['valor'],
                ],
            );

            $autoresIds = Autor::whereIn('nome', $dados['autores'])->pluck('cod_au');
            $assuntosIds = Assunto::whereIn('descricao', $dados['assuntos'])->pluck('cod_as');

            $livro->autores()->sync($autoresIds);
            $livro->assuntos()->sync($assuntosIds);
        }
    }
}
