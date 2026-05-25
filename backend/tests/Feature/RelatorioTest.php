<?php

namespace Tests\Feature;

use App\Models\Assunto;
use App\Models\Autor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RelatorioTest extends TestCase
{
    use RefreshDatabase;

    public function test_relatorio_returns_empty_when_no_livros(): void
    {
        $this->getJson('/api/v1/relatorio/livros-por-autor')
            ->assertOk()
            ->assertJson(['data' => []]);
    }

    public function test_relatorio_retorna_livros_agrupados_por_autor(): void
    {
        $autor = Autor::create(['nome' => 'Machado de Assis']);
        $assunto = Assunto::create(['descricao' => 'Romance']);

        $this->postJson('/api/v1/livros', [
            'titulo' => 'Dom Casmurro',
            'editora' => 'Garnier',
            'edicao' => 1,
            'ano_publicacao' => '1899',
            'valor' => 19.90,
            'autores_ids' => [$autor->cod_au],
            'assuntos_ids' => [$assunto->cod_as],
        ]);

        $this->getJson('/api/v1/relatorio/livros-por-autor')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.autor_nome', 'Machado de Assis')
            ->assertJsonCount(1, 'data.0.livros')
            ->assertJsonPath('data.0.livros.0.titulo', 'Dom Casmurro');
    }

    public function test_livro_com_dois_autores_aparece_em_ambos(): void
    {
        $autor1 = Autor::create(['nome' => 'Autor Um']);
        $autor2 = Autor::create(['nome' => 'Autor Dois']);
        $assunto = Assunto::create(['descricao' => 'Coautoria']);

        $this->postJson('/api/v1/livros', [
            'titulo' => 'Livro Coautorado',
            'editora' => 'Editora',
            'edicao' => 1,
            'ano_publicacao' => '2020',
            'valor' => 39.90,
            'autores_ids' => [$autor1->cod_au, $autor2->cod_au],
            'assuntos_ids' => [$assunto->cod_as],
        ]);

        $this->getJson('/api/v1/relatorio/livros-por-autor')
            ->assertOk()
            ->assertJsonCount(2, 'data');
    }
}
