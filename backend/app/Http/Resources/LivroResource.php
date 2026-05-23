<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LivroResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->cod_l,
            'titulo' => $this->titulo,
            'editora' => $this->editora,
            'edicao' => $this->edicao,
            'ano_publicacao' => $this->ano_publicacao,
            'valor' => number_format((float) $this->valor, 2, '.', ''),
            'autores' => AutorResource::collection($this->whenLoaded('autores')),
            'assuntos' => AssuntoResource::collection($this->whenLoaded('assuntos')),
        ];
    }
}
