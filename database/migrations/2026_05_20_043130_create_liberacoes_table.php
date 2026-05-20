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
        Schema::create('liberacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aluno_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('aqv_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('escala_professor_id')->constrained('escala_professores')->cascadeOnDelete();
            $table->enum("tipo", ['saida', 'entrada'])->default('saida');
            $table->enum('frequencia_professor', ['pendente', 'falta', 'sem_falta'])->default('pendente');
            $table->enum('status_portaria',['aguardando', 'liberado', 'nao_compareceu'])->default('aguardando');
            $table->time('horario_previsto');
            $table->time('horario_real')->nullable(); // Horario que o aluno foi liberado na portaria
            $table->text("observacao")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('liberacoes');
    }
};
