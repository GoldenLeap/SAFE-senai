<?php

namespace App\Filament\Aqv\Resources\Liberacaos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
class LiberacaosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('aluno.nome')
                    ->searchable()
                    ->sortable()
                    ->label('Aluno'),
                TextColumn::make('tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'saida' => 'danger',
                        'entrada' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'saida' => 'Saída Antecipada',
                        'entrada' => 'Entrada Tardia',
                        default => $state,
                    })
                    ->label('Tipo'),
                TextColumn::make('escalaProfessor.turmaDisciplina.turma.nome')
                    ->label('Turma')
                    ->sortable(),
                TextColumn::make('escalaProfessor.turmaDisciplina.disciplina.nome')
                    ->label('Disciplina')
                    ->sortable(),
                TextColumn::make('escalaProfessor.professor.nome')
                    ->label('Professor')
                    ->sortable(),
                TextColumn::make('horario_previsto')
                    ->time('H:i')
                    ->label('Horário Previsto'),
                TextColumn::make('horario_real')
                    ->time('H:i')
                    ->placeholder('--:--')
                    ->label('Horário Real'),
                TextColumn::make('status_portaria')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'aguardando' => 'info',
                        'liberado' => 'success',
                        'nao_compareceu' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'aguardando' => 'Aguardando no Portão',
                        'liberado' => 'Liberado',
                        'nao_compareceu' => 'Não Compareceu',
                        default => $state,
                    })
                    ->label('Status Portaria'),
                TextColumn::make('frequencia_professor')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pendente' => 'warning',
                        'falta' => 'danger',
                        'sem_falta' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pendente' => 'Pendente',
                        'falta' => 'Falta',
                        'sem_falta' => 'Presença Justificada',
                        default => $state,
                    })
                    ->label('Frequência'),
            ])
            ->filters([
                SelectFilter::make('status_portaria')
                ->options([
                    'aguardando' => 'Aguardando',
                    'liberado' => 'Liberado',
                ])
                ->label('Filtrar por Status'),

            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
