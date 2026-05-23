<?php

namespace App\DTOs;

readonly class AutorDTO
{
    public function __construct(
        public string $nome,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            nome: $data['nome'],
        );
    }
}
