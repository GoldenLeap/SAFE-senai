<?php

namespace App\Filament\Professor\Widgets;

use App\Models\Liberacao;
use App\Models\EscalaProfessor;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProfessorStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $professorId = auth()->id();

        $pendentesCount = Liberacao::where('frequencia_professor', 'pendente')
            ->whereHas('escalaProfessor', function ($query) use ($professorId) {
                $query->where('professor_id', $professorId);
            })->count();

        $escalasCount = EscalaProfessor::where('professor_id', $professorId)->count();

        return [
            Stat::make('Minhas Aulas / Horários', $escalasCount)
                ->description('Minhas escalas de aula cadastradas')
                ->descriptionIcon('heroicon-o-academic-cap')
                ->color('danger'),
            Stat::make('Liberações Pendentes', $pendentesCount)
                ->description('Alunos ausentes aguardando validação de presença')
                ->descriptionIcon('heroicon-o-exclamation-circle')
                ->color($pendentesCount > 0 ? 'warning' : 'success'),
        ];
    }
}
