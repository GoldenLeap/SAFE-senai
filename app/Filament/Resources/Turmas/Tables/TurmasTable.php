<?php

namespace App\Filament\Resources\Turmas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

use Filament\Tables\Columns\TextColumn;

class TurmasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome')
                    ->searchable()
                    ->sortable()
                    ->label('Nome da Turma'),
                TextColumn::make('periodo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Matutino' => 'info',
                        'Vespertino' => 'warning',
                        'Noturno' => 'success',
                        default => 'gray',
                    })
                    ->sortable()
                    ->label('Período'),
                TextColumn::make('disciplinas_count')
                    ->counts('disciplinas')
                    ->sortable()
                    ->label('Nº de Disciplinas'),
                TextColumn::make('alunos_count')
                    ->counts('alunos')
                    ->sortable()
                    ->label('Nº de Alunos'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
