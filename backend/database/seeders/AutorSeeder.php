<?php

namespace Database\Seeders;

use App\Models\Autor;
use Illuminate\Database\Seeder;

class AutorSeeder extends Seeder
{
    public function run(): void
    {
        $autores = [
            'Machado de Assis',
            'Clarice Lispector',
            'Paulo Coelho',
            'Jorge Amado',
            'Guimarães Rosa',
        ];

        foreach ($autores as $nome) {
            Autor::firstOrCreate(['nome' => $nome]);
        }
    }
}
