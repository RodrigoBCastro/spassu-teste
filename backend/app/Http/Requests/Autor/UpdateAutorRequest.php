<?php

namespace App\Http\Requests\Autor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAutorRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:40', Rule::unique('autores', 'nome')->ignore($this->route('autore'), 'cod_au')],
        ];
    }
}
