<?php

namespace App\Http\Requests\Livro;

use Illuminate\Foundation\Http\FormRequest;

class StoreLivroRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'max:40'],
            'editora' => ['required', 'string', 'max:40'],
            'edicao' => ['required', 'integer', 'min:1'],
            'ano_publicacao' => ['required', 'string', 'size:4', 'regex:/^\d{4}$/', function ($attr, $val, $fail) { if ((int) $val > (int) date('Y')) $fail('O ano de publicação não pode ser futuro.'); }],
            'valor' => ['required', 'numeric', 'min:0'],
            'autores_ids' => ['required', 'array', 'min:1'],
            'autores_ids.*' => ['integer', 'exists:autores,cod_au'],
            'assuntos_ids' => ['required', 'array', 'min:1'],
            'assuntos_ids.*' => ['integer', 'exists:assuntos,cod_as'],
        ];
    }
}
