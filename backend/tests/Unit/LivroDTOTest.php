<?php

namespace Tests\Unit;

use App\DTOs\LivroDTO;
use PHPUnit\Framework\TestCase;

class LivroDTOTest extends TestCase
{
    public function test_creates_dto_from_array(): void
    {
        $dto = LivroDTO::fromArray([
            'titulo' => 'Dom Casmurro',
            'editora' => 'Garnier',
            'edicao' => 1,
            'ano_publicacao' => '1899',
            'valor' => 29.90,
            'autores_ids' => [1, 2],
            'assuntos_ids' => [3],
        ]);

        $this->assertSame('Dom Casmurro', $dto->titulo);
        $this->assertSame('Garnier', $dto->editora);
        $this->assertSame(1, $dto->edicao);
        $this->assertSame('1899', $dto->anoPublicacao);
        $this->assertSame(29.90, $dto->valor);
        $this->assertSame([1, 2], $dto->autoresIds);
        $this->assertSame([3], $dto->assuntosIds);
    }

    public function test_autores_e_assuntos_ids_default_para_array_vazio(): void
    {
        $dto = LivroDTO::fromArray([
            'titulo' => 'Teste',
            'editora' => 'Editora',
            'edicao' => 1,
            'ano_publicacao' => '2020',
            'valor' => 10.0,
        ]);

        $this->assertSame([], $dto->autoresIds);
        $this->assertSame([], $dto->assuntosIds);
    }
}
