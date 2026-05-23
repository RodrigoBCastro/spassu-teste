<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Livro extends Model
{
    protected $primaryKey = 'cod_l';

    public $timestamps = false;

    protected $fillable = [
        'titulo',
        'editora',
        'edicao',
        'ano_publicacao',
        'valor',
    ];

    protected function casts(): array
    {
        return [
            'edicao' => 'integer',
            'valor'  => 'decimal:2',
        ];
    }

    public function autores(): BelongsToMany
    {
        return $this->belongsToMany(
            Autor::class,
            'livro_autor',
            'livro_cod_l',
            'autor_cod_au',
            'cod_l',
            'cod_au',
        );
    }

    public function assuntos(): BelongsToMany
    {
        return $this->belongsToMany(
            Assunto::class,
            'livro_assunto',
            'livro_cod_l',
            'assunto_cod_as',
            'cod_l',
            'cod_as',
        );
    }
}
