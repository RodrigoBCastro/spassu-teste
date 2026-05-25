<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('autores', function (Blueprint $table): void {
            $table->increments('cod_au');
            $table->string('nome', 40)->unique();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('autores');
    }
};
