<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nome', 'periodo'])]
class Turma extends Model
{
    /** @use HasFactory<\Database\Factories\TurmaFactory> */
    use HasFactory;


    public function alunos()
    {
        return $this->belongsToMany(User::class, 'aluno_turma', 'turma_id', 'aluno_id');

    }

    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class, 'turma_disciplinas');

    }

}
