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
            'Drama',
            'Aventura',
            'Fantasia',
            'Suspense',
            'Biografia',
            'História do Brasil',
            'Filosofia',
            'Psicologia',
            'Educação',
            'Literatura Infantojuvenil',
            'Terror',
            'Thriller',
            'Sociologia',
            'Política',
            'Memórias',
            'Teatro',
            'Modernismo',
            'Romantismo',
            'Realismo',
            'Naturalismo',
            'Regionalismo',
            'Cordel',
        ];

        foreach ($assuntos as $descricao) {
            Assunto::firstOrCreate(['descricao' => $descricao]);
        }
    }
}
