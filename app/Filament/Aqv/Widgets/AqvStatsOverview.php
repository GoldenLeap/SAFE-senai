<?php

namespace App\Filament\Aqv\Widgets;

use App\Models\Liberacao;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AqvStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Aguardando na Portaria', Liberacao::where('status_portaria', 'aguardando')->count())
                ->description('Alunos esperando liberação física')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),
            Stat::make('Liberados Hoje', Liberacao::where('status_portaria', 'liberado')->whereDate('created_at', today())->count())
                ->description('Total de entradas/saídas hoje')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),
            Stat::make('Validações de Professor Pendentes', Liberacao::where('frequencia_professor', 'pendente')->count())
                ->description('Faltas/presenças por processar')
                ->descriptionIcon('heroicon-o-exclamation-triangle')
                ->color('danger'),
        ];
    }
}
