<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'Autor', properties: [
    new OA\Property(property: 'id', type: 'integer', example: 1),
    new OA\Property(property: 'nome', type: 'string', example: 'Machado de Assis'),
], type: 'object')]
#[OA\Schema(schema: 'AutorInput', required: ['nome'], properties: [
    new OA\Property(property: 'nome', type: 'string', example: 'Machado de Assis', maxLength: 40),
], type: 'object')]
#[OA\Schema(schema: 'Assunto', properties: [
    new OA\Property(property: 'id', type: 'integer', example: 1),
    new OA\Property(property: 'descricao', type: 'string', example: 'Romance'),
], type: 'object')]
#[OA\Schema(schema: 'AssuntoInput', required: ['descricao'], properties: [
    new OA\Property(property: 'descricao', type: 'string', example: 'Romance', maxLength: 100),
], type: 'object')]
#[OA\Schema(schema: 'Livro', properties: [
    new OA\Property(property: 'id', type: 'integer', example: 1),
    new OA\Property(property: 'titulo', type: 'string', example: 'Dom Casmurro'),
    new OA\Property(property: 'editora', type: 'string', example: 'Garnier'),
    new OA\Property(property: 'edicao', type: 'integer', example: 1),
    new OA\Property(property: 'ano_publicacao', type: 'string', example: '1899'),
    new OA\Property(property: 'valor', type: 'string', example: '29.90'),
    new OA\Property(property: 'autores', type: 'array', items: new OA\Items(ref: '#/components/schemas/Autor')),
    new OA\Property(property: 'assuntos', type: 'array', items: new OA\Items(ref: '#/components/schemas/Assunto')),
], type: 'object')]
#[OA\Schema(schema: 'LivroInput', required: ['titulo', 'editora', 'edicao', 'ano_publicacao', 'valor', 'autores_ids', 'assuntos_ids'], properties: [
    new OA\Property(property: 'titulo', type: 'string', example: 'Dom Casmurro', maxLength: 40),
    new OA\Property(property: 'editora', type: 'string', example: 'Garnier', maxLength: 40),
    new OA\Property(property: 'edicao', type: 'integer', example: 1, minimum: 1),
    new OA\Property(property: 'ano_publicacao', type: 'string', example: '1899'),
    new OA\Property(property: 'valor', type: 'number', format: 'float', example: 29.90, minimum: 0),
    new OA\Property(property: 'autores_ids', type: 'array', items: new OA\Items(type: 'integer'), example: [1, 2]),
    new OA\Property(property: 'assuntos_ids', type: 'array', items: new OA\Items(type: 'integer'), example: [1]),
], type: 'object')]
#[OA\Schema(schema: 'RelatorioLivro', properties: [
    new OA\Property(property: 'cod_l', type: 'integer', example: 1),
    new OA\Property(property: 'titulo', type: 'string', example: 'Dom Casmurro'),
    new OA\Property(property: 'editora', type: 'string', example: 'Garnier'),
    new OA\Property(property: 'edicao', type: 'integer', example: 1),
    new OA\Property(property: 'ano_publicacao', type: 'string', example: '1899'),
    new OA\Property(property: 'valor', type: 'number', format: 'float', example: 29.90),
    new OA\Property(property: 'assuntos', type: 'string', example: 'Romance, Realismo'),
], type: 'object')]
#[OA\Schema(schema: 'RelatorioAutor', properties: [
    new OA\Property(property: 'cod_au', type: 'integer', example: 1),
    new OA\Property(property: 'autor_nome', type: 'string', example: 'Machado de Assis'),
    new OA\Property(property: 'livros', type: 'array', items: new OA\Items(ref: '#/components/schemas/RelatorioLivro')),
], type: 'object')]
class SchemaController {}
