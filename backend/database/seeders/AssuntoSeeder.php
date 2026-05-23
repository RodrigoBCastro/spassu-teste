<?php

namespace Database\Seeders;

use App\Models\Assunto;
use Illuminate\Database\Seeder;

class AssuntoSeeder extends Seeder
{
    public function run(): void
    {
        $assuntos = [
            'Literatura Brasileira',
            'Romance',
            'Ficção',
            'Poesia',
            'Crônica',
            'Conto',
            'Clássico',
            'Autoajuda',
        ];

        foreach ($assuntos as $descricao) {
            Assunto::firstOrCreate(['descricao' => $descricao]);
        }
    }
}
