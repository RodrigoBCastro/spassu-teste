<?php

namespace Tests\Feature;

use App\Models\Assunto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssuntoTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_assuntos(): void
    {
        Assunto::create(['descricao' => 'Romance']);

        $this->getJson('/api/v1/assuntos')
            ->assertOk()
            ->assertJsonStructure(['data' => [['id', 'descricao']]]);
    }

    public function test_can_create_assunto(): void
    {
        $this->postJson('/api/v1/assuntos', ['descricao' => 'Ficção Científica'])
            ->assertCreated()
            ->assertJsonPath('data.descricao', 'Ficção Científica');

        $this->assertDatabaseHas('assuntos', ['descricao' => 'Ficção Científica']);
    }

    public function test_cannot_create_assunto_without_descricao(): void
    {
        $this->postJson('/api/v1/assuntos', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['descricao']);
    }

    public function test_cannot_create_assunto_with_duplicate_descricao(): void
    {
        Assunto::create(['descricao' => 'Descrição Duplicada']);

        $this->postJson('/api/v1/assuntos', ['descricao' => 'Descrição Duplicada'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['descricao']);
    }

    public function test_can_show_assunto(): void
    {
        $assunto = Assunto::create(['descricao' => 'Poesia']);

        $this->getJson("/api/v1/assuntos/{$assunto->cod_as}")
            ->assertOk()
            ->assertJsonPath('data.id', $assunto->cod_as)
            ->assertJsonPath('data.descricao', 'Poesia');
    }

    public function test_returns_404_for_nonexistent_assunto(): void
    {
        $this->getJson('/api/v1/assuntos/99999')
            ->assertNotFound();
    }

    public function test_can_update_assunto(): void
    {
        $assunto = Assunto::create(['descricao' => 'Conto']);

        $this->putJson("/api/v1/assuntos/{$assunto->cod_as}", ['descricao' => 'Crônica'])
            ->assertOk()
            ->assertJsonPath('data.descricao', 'Crônica');
    }

    public function test_can_update_assunto_keeping_same_descricao(): void
    {
        $assunto = Assunto::create(['descricao' => 'Biografia']);

        $this->putJson("/api/v1/assuntos/{$assunto->cod_as}", ['descricao' => 'Biografia'])
            ->assertOk();
    }

    public function test_can_delete_assunto(): void
    {
        $assunto = Assunto::create(['descricao' => 'Assunto Temporário']);

        $this->deleteJson("/api/v1/assuntos/{$assunto->cod_as}")
            ->assertNoContent();

        $this->assertDatabaseMissing('assuntos', ['cod_as' => $assunto->cod_as]);
    }
}
