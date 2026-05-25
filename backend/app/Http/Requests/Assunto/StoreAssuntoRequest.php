<?php

namespace App\Http\Requests\Assunto;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssuntoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'descricao' => ['required', 'string', 'max:100', 'unique:assuntos,descricao'],
        ];
    }
}
