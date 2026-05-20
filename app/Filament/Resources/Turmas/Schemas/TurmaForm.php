<?php

namespace App\Filament\Resources\Turmas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class TurmaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nome')
                    ->required()
                    ->label('Nome da Turma')
                    ->placeholder('Ex: 3º Ano Informática'),
                Select::make('periodo')
                    ->options([
                        'Matutino' => 'Matutino',
                        'Vespertino' => 'Vespertino',
                        'Noturno' => 'Noturno',
                    ])
                    ->required()
                    ->label('Período'),
                Select::make('disciplinas')
                    ->multiple()
                    ->relationship('disciplinas', 'nome')
                    ->preload()
                    ->label('Disciplinas Vinculadas'),
                Select::make('alunos')
                    ->multiple()
                    ->relationship('alunos', 'nome', fn ($query) => $query->where('cargo', 'aluno'))
                    ->preload()
                    ->label('Alunos da Turma'),
            ]);
    }
}
