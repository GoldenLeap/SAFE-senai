<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Table('liberacao_historicos')]
#[Fillable([
    'liberacao_id',
    'user_id',
    'acao',
    'descricao',
])]
class LiberacaoHistorico extends Model
{
    use HasFactory;

    public function liberacao()
    {
        return $this->belongsTo(Liberacao::class, 'liberacao_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
