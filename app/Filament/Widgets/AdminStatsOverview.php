<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Turma;
use App\Models\Disciplina;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Alunos Cadastrados', User::where('cargo', 'aluno')->count())
                ->description('Total de alunos no sistema')
                ->descriptionIcon('heroicon-o-academic-cap')
                ->color('danger'),
            Stat::make('Colaboradores', User::where('cargo', '!=', 'aluno')->count())
                ->description('Professores, AQV e portaria')
                ->descriptionIcon('heroicon-o-users')
                ->color('danger'),
            Stat::make('Turmas Ativas', Turma::count())
                ->description('Turmas registradas')
                ->descriptionIcon('heroicon-o-rectangle-group')
                ->color('danger'),
            Stat::make('Disciplinas', Disciplina::count())
                ->description('Disciplinas na grade curricular')
                ->descriptionIcon('heroicon-o-book-open')
                ->color('danger'),
        ];
    }
}
