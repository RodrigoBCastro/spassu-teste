<?php

namespace App\Http\Requests\Assunto;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAssuntoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'descricao' => ['required', 'string', 'max:100', Rule::unique('assuntos', 'descricao')->ignore($this->route('assunto'), 'cod_as')],
        ];
    }
}
