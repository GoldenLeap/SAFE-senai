<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


#[Fillable(['nome'])]
class Disciplina extends Model
{
    /** @use HasFactory<\Database\Factories\DisciplinaFactory> */
    use HasFactory;

    public function turmas(){
       return $this->belongsToMany(Turma::class, 'turma_disciplinas');
    }

}
