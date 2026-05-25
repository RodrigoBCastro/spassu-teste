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
            'Carlos Drummond de Andrade',
            'Cecília Meireles',
            'Érico Veríssimo',
            'Graciliano Ramos',
            'Mário de Andrade',
            'Oswald de Andrade',
            'Rachel de Queiroz',
            'Lygia Fagundes Telles',
            'Rubem Braga',
            'Ariano Suassuna',
            'Lima Barreto',
            'Monteiro Lobato',
            'Euclides da Cunha',
            'Aluísio Azevedo',
            'José de Alencar',
            'Olavo Bilac',
            'Castro Alves',
            'Cruz e Sousa',
            'João Cabral de Melo Neto',
            'Dalton Trevisan',
            'Autran Dourado',
            'Nélida Piñon',
            'Milton Hatoum',
            'Raduan Nassar',
            'Rubem Fonseca',
            'Ferreira Gullar',
            'Patativa do Assaré',
        ];

        foreach ($autores as $nome) {
            Autor::firstOrCreate(['nome' => $nome]);
        }
    }
}
