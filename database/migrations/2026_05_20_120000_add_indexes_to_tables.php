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
        Schema::table('escala_professores', function (Blueprint $table) {
            $table->index('professor_id');
            $table->index('turma_disciplina_id');
        });

        Schema::table('liberacoes', function (Blueprint $table) {
            $table->index('aluno_id');
            $table->index('aqv_id');
            $table->index('escala_professor_id');
            $table->index('status_portaria');
            $table->index('frequencia_professor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('escala_professores', function (Blueprint $table) {
            $table->dropIndex(['professor_id']);
            $table->dropIndex(['turma_disciplina_id']);
        });

        Schema::table('liberacoes', function (Blueprint $table) {
            $table->dropIndex(['aluno_id']);
            $table->dropIndex(['aqv_id']);
            $table->dropIndex(['escala_professor_id']);
            $table->dropIndex(['status_portaria']);
            $table->dropIndex(['frequencia_professor']);
        });
    }
};
