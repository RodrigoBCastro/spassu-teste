<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('livro_assunto', function (Blueprint $table): void {
            $table->unsignedInteger('livro_cod_l');
            $table->unsignedInteger('assunto_cod_as');

            $table->primary(['livro_cod_l', 'assunto_cod_as']);

            $table->foreign('livro_cod_l')
                ->references('cod_l')
                ->on('livros')
                ->onDelete('cascade');

            $table->foreign('assunto_cod_as')
                ->references('cod_as')
                ->on('assuntos')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('livro_assunto');
    }
};
