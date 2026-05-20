<?php

namespace App\Filament\Professor\Resources\Liberacaos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use App\Models\Liberacao;

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
                    ->label('Turma'),
                TextColumn::make('escalaProfessor.turmaDisciplina.disciplina.nome')
                    ->label('Disciplina'),
                TextColumn::make('escalaProfessor.periodo')
                    ->label('Tempo / Aula'),
                TextColumn::make('horario_previsto')
                    ->time('H:i')
                    ->label('Horário Previsto'),
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
                //
            ])
            ->actions([
                Action::make('justificar')
                    ->label('Justificar Presença')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Justificar Presença')
                    ->modalDescription('Você confirma que o aluno está/estará presente em sala, justificando a falta?')
                    ->action(function (Liberacao $record) {
                        $record->update([
                            'frequencia_professor' => 'sem_falta',
                        ]);
                    }),
                Action::make('falta')
                    ->label('Dar Falta')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Dar Falta')
                    ->modalDescription('Você confirma a falta deste aluno em sua aula?')
                    ->action(function (Liberacao $record) {
                        $record->update([
                            'frequencia_professor' => 'falta',
                        ]);
                    }),
            ]);
    }
}
