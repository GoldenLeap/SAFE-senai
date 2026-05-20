<?php

namespace App\Filament\Portaria\Widgets;

use App\Models\Liberacao;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PortariaStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Liberações Pendentes', Liberacao::where('status_portaria', 'aguardando')->count())
                ->description('Alunos aguardando liberação no portão')
                ->descriptionIcon('heroicon-o-shield-exclamation')
                ->color('warning'),
            Stat::make('Alunos Liberados Hoje', Liberacao::where('status_portaria', 'liberado')->whereDate('created_at', today())->count())
                ->description('Acesso físico concluído hoje')
                ->descriptionIcon('heroicon-o-check-badge')
                ->color('success'),
        ];
    }
}
