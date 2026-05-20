<?php

namespace App\Filament\Portaria\Resources\Liberacaos\Tables;

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
                TextColumn::make('horario_previsto')
                    ->time('H:i')
                    ->label('Horário Previsto'),
                TextColumn::make('observacao')
                    ->limit(35)
                    ->label('Observação / Motivo'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('liberar')
                    ->label('Liberar Aluno')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Confirmar Liberação')
                    ->modalDescription('Você confirma a saída/entrada deste aluno neste momento?')
                    ->action(function (Liberacao $record) {
                        $record->update([
                            'status_portaria' => 'liberado',
                            'horario_real' => now()->format('H:i:s'),
                        ]);
                    })
            ]);
    }
}
