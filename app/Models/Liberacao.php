<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Table('liberacoes')]
#[Fillable([
    'aluno_id',
    'aqv_id',
    'escala_professor_id',
    'tipo',
    'frequencia_professor',
    'status_portaria',
    'horario_previsto',
    'horario_real',
    'observacao',
])]
class Liberacao extends Model
{
    /** @use HasFactory<\Database\Factories\LiberacaoFactory> */
    use HasFactory;

    public function aluno()
    {
        return $this->belongsTo(User::class, 'aluno_id');
    }

    public function aqv()
    {
        return $this->belongsTo(User::class, 'aqv_id');
    }

    public function escalaProfessor()
    {
        return $this->belongsTo(EscalaProfessor::class, 'escala_professor_id');
    }
}
