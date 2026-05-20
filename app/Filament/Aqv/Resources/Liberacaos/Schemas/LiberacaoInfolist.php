<?php

namespace App\Filament\Aqv\Resources\Liberacaos\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class LiberacaoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('aluno.nome')
                    ->label('Aluno'),
                TextEntry::make('aqv.nome')
                    ->label('Responsável AQV'),
                TextEntry::make('escalaProfessor.professor.nome')
                    ->label('Professor Responsável'),
                TextEntry::make('escalaProfessor.turmaDisciplina.turma.nome')
                    ->label('Turma'),
                TextEntry::make('escalaProfessor.turmaDisciplina.disciplina.nome')
                    ->label('Disciplina'),
                TextEntry::make('escalaProfessor.periodo')
                    ->label('Tempo / Aula'),
                TextEntry::make('tipo')
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
                    ->label('Tipo de Liberação'),
                TextEntry::make('status_portaria')
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
                TextEntry::make('frequencia_professor')
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
                    ->label('Frequência em Sala'),
                TextEntry::make('horario_previsto')
                    ->time('H:i')
                    ->label('Horário Previsto'),
                TextEntry::make('horario_real')
                    ->time('H:i')
                    ->placeholder('--:--')
                    ->label('Horário Real'),
                TextEntry::make('observacao')
                    ->placeholder('-')
                    ->columnSpanFull()
                    ->label('Observação / Motivo'),
                TextEntry::make('created_at')
                    ->dateTime('d/m/Y H:i')
                    ->label('Criado em'),
                TextEntry::make('updated_at')
                    ->dateTime('d/m/Y H:i')
                    ->label('Última Atualização'),
            ]);
    }
}
