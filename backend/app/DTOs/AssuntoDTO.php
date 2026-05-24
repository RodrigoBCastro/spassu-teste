<?php

namespace App\DTOs;

readonly class AssuntoDTO
{
    public function __construct(
        public string $descricao,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            descricao: $data['descricao'],
        );
    }
}
