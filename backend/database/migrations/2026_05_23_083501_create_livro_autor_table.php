<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('livro_autor', function (Blueprint $table): void {
            $table->unsignedInteger('livro_cod_l');
            $table->unsignedInteger('autor_cod_au');

            $table->primary(['livro_cod_l', 'autor_cod_au']);

            $table->foreign('livro_cod_l')
                ->references('cod_l')
                ->on('livros')
                ->onDelete('cascade');

            $table->foreign('autor_cod_au')
                ->references('cod_au')
                ->on('autores')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('livro_autor');
    }
};
