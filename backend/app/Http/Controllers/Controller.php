<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(version: '1.0.0', description: 'API REST para gerenciamento de livros, autores e assuntos.', title: 'Cadastro de Livros API')]
#[OA\Server(url: '/api/v1')]
#[OA\Tag(name: 'Autores', description: 'CRUD de autores')]
#[OA\Tag(name: 'Assuntos', description: 'CRUD de assuntos')]
#[OA\Tag(name: 'Livros', description: 'CRUD de livros')]
#[OA\Tag(name: 'Relatório', description: 'Relatório de livros por autor')]
abstract class Controller
{
}
