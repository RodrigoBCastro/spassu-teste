<?php

namespace App\DTOs;

readonly class LivroDTO
{
    public function __construct(
        public string $titulo,
        public string $editora,
        public int $edicao,
        public string $anoPublicacao,
        public float $valor,
        public array $autoresIds,
        public array $assuntosIds,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            titulo: $data['titulo'],
            editora: $data['editora'],
            edicao: (int) $data['edicao'],
            anoPublicacao: $data['ano_publicacao'],
            valor: (float) $data['valor'],
            autoresIds: $data['autores_ids'] ?? [],
            assuntosIds: $data['assuntos_ids'] ?? [],
        );
    }
}
