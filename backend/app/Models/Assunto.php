<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Assunto extends Model
{
    protected $primaryKey = 'cod_as';

    public $timestamps = false;

    protected $fillable = ['descricao'];

    public function livros(): BelongsToMany
    {
        return $this->belongsToMany(
            Livro::class,
            'livro_assunto',
            'assunto_cod_as',
            'livro_cod_l',
            'cod_as',
            'cod_l',
        );
    }
}
