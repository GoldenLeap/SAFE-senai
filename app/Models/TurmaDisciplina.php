<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Table('turma_disciplinas')]
class TurmaDisciplina extends Model
{
    /** @use HasFactory<\Database\Factories\TurmaDisciplinaFactory> */
    use HasFactory;
    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class);
    }
}
