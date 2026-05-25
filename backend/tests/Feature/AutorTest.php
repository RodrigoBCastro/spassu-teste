<?php

namespace Tests\Feature;

use App\Models\Autor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AutorTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_autores(): void
    {
        Autor::create(['nome' => 'Machado de Assis']);

        $this->getJson('/api/v1/autores')
            ->assertOk()
            ->assertJsonStructure(['data' => [['id', 'nome']]]);
    }

    public function test_can_create_autor(): void
    {
        $this->postJson('/api/v1/autores', ['nome' => 'Jorge Amado'])
            ->assertCreated()
            ->assertJsonPath('data.nome', 'Jorge Amado');

        $this->assertDatabaseHas('autores', ['nome' => 'Jorge Amado']);
    }

    public function test_cannot_create_autor_without_nome(): void
    {
        $this->postJson('/api/v1/autores', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['nome']);
    }

    public function test_cannot_create_autor_with_duplicate_nome(): void
    {
        Autor::create(['nome' => 'Nome Duplicado']);

        $this->postJson('/api/v1/autores', ['nome' => 'Nome Duplicado'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['nome']);
    }

    public function test_can_show_autor(): void
    {
        $autor = Autor::create(['nome' => 'Clarice Lispector']);

        $this->getJson("/api/v1/autores/{$autor->cod_au}")
            ->assertOk()
            ->assertJsonPath('data.id', $autor->cod_au)
            ->assertJsonPath('data.nome', 'Clarice Lispector');
    }

    public function test_returns_404_for_nonexistent_autor(): void
    {
        $this->getJson('/api/v1/autores/99999')
            ->assertNotFound();
    }

    public function test_can_update_autor(): void
    {
        $autor = Autor::create(['nome' => 'Nome Antigo']);

        $this->putJson("/api/v1/autores/{$autor->cod_au}", ['nome' => 'Nome Atualizado'])
            ->assertOk()
            ->assertJsonPath('data.nome', 'Nome Atualizado');

        $this->assertDatabaseHas('autores', ['cod_au' => $autor->cod_au, 'nome' => 'Nome Atualizado']);
    }

    public function test_can_update_autor_keeping_same_nome(): void
    {
        $autor = Autor::create(['nome' => 'Nome Único']);

        $this->putJson("/api/v1/autores/{$autor->cod_au}", ['nome' => 'Nome Único'])
            ->assertOk();
    }

    public function test_can_delete_autor(): void
    {
        $autor = Autor::create(['nome' => 'Autor Temporário']);

        $this->deleteJson("/api/v1/autores/{$autor->cod_au}")
            ->assertNoContent();

        $this->assertDatabaseMissing('autores', ['cod_au' => $autor->cod_au]);
    }
}
