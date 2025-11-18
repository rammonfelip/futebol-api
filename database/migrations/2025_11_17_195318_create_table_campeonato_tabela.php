<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('campeonato_tabela', function (Blueprint $table) {
            $table->integer('campeonato_id');
            $table->integer('time_id');
            $table->string('time_nome');
            $table->string('time_sigla');
            $table->string('time_logo');
            $table->integer('posicao')->default(0);
            $table->integer('pontos')->default(0);
            $table->integer('jogos')->default(0);
            $table->integer('vitorias')->default(0);
            $table->integer('empates')->default(0);
            $table->integer('derrotas')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campeonato_tabela');
    }
};
