<?php

namespace Tests\Feature;

use App\Models\Assunto;
use App\Models\Autor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LivroTest extends TestCase
{
    use RefreshDatabase;

    private Autor $autor;
    private Assunto $assunto;

    protected function setUp(): void
    {
        parent::setUp();
        $this->autor = Autor::create(['nome' => 'Autor Teste']);
        $this->assunto = Assunto::create(['descricao' => 'Assunto Teste']);
    }

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'titulo' => 'Dom Casmurro',
            'editora' => 'Garnier',
            'edicao' => 1,
            'ano_publicacao' => '1899',
            'valor' => 29.90,
            'autores_ids' => [$this->autor->cod_au],
            'assuntos_ids' => [$this->assunto->cod_as],
        ], $overrides);
    }

    public function test_can_list_livros(): void
    {
        $this->postJson('/api/v1/livros', $this->payload());

        $this->getJson('/api/v1/livros')
            ->assertOk()
            ->assertJsonStructure(['data' => [['id', 'titulo', 'editora', 'edicao', 'ano_publicacao', 'valor']]]);
    }

    public function test_can_create_livro(): void
    {
        $this->postJson('/api/v1/livros', $this->payload())
            ->assertCreated()
            ->assertJsonPath('data.titulo', 'Dom Casmurro')
            ->assertJsonPath('data.valor', '29.90');

        $this->assertDatabaseHas('livros', ['titulo' => 'Dom Casmurro']);
    }

    public function test_cannot_create_livro_without_required_fields(): void
    {
        $this->postJson('/api/v1/livros', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['titulo', 'editora', 'edicao', 'ano_publicacao', 'valor', 'autores_ids', 'assuntos_ids']);
    }

    public function test_cannot_create_livro_with_future_year(): void
    {
        $futureYear = (string) (date('Y') + 1);

        $this->postJson('/api/v1/livros', $this->payload(['ano_publicacao' => $futureYear]))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['ano_publicacao']);
    }

    public function test_cannot_create_livro_with_nonexistent_autor(): void
    {
        $this->postJson('/api/v1/livros', $this->payload(['autores_ids' => [99999]]))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['autores_ids.0']);
    }

    public function test_can_show_livro(): void
    {
        $id = $this->postJson('/api/v1/livros', $this->payload())->json('data.id');

        $this->getJson("/api/v1/livros/{$id}")
            ->assertOk()
            ->assertJsonPath('data.titulo', 'Dom Casmurro');
    }

    public function test_returns_404_for_nonexistent_livro(): void
    {
        $this->getJson('/api/v1/livros/99999')
            ->assertNotFound();
    }

    public function test_can_update_livro(): void
    {
        $id = $this->postJson('/api/v1/livros', $this->payload())->json('data.id');

        $this->putJson("/api/v1/livros/{$id}", $this->payload(['titulo' => 'Memórias Póstumas']))
            ->assertOk()
            ->assertJsonPath('data.titulo', 'Memórias Póstumas');
    }

    public function test_can_delete_livro(): void
    {
        $id = $this->postJson('/api/v1/livros', $this->payload())->json('data.id');

        $this->deleteJson("/api/v1/livros/{$id}")
            ->assertNoContent();

        $this->assertDatabaseMissing('livros', ['cod_l' => $id]);
    }
}
