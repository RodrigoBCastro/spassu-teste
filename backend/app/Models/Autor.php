<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Autor extends Model
{
    protected $table = 'autores';

    protected $primaryKey = 'cod_au';

    public $timestamps = false;

    protected $fillable = ['nome'];

    public function livros(): BelongsToMany
    {
        return $this->belongsToMany(
            Livro::class,
            'livro_autor',
            'autor_cod_au',
            'livro_cod_l',
            'cod_au',
            'cod_l',
        );
    }
}
