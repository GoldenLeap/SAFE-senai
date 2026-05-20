<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Table('escala_professores')]
#[Fillable(['professor_id', 'turma_disciplina_id', 'periodo'])]
class EscalaProfessor extends Model
{
    /** @use HasFactory<\Database\Factories\EscalaProfessorFactory> */
    use HasFactory;

    public function professor()
    {
        return $this->belongsTo(User::class, 'professor_id');
    }

    public function turmaDisciplina()
    {
        return $this->belongsTo(TurmaDisciplina::class, 'turma_disciplina_id');
    }

    public function liberacoes()
    {
        return $this->hasMany(Liberacao::class, 'escala_professor_id');
    }
}
