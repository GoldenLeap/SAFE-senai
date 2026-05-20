<?php

namespace App\Filament\Professor\Resources\Liberacaos\Pages;

use App\Filament\Professor\Resources\Liberacaos\LiberacaoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListLiberacaos extends ListRecords
{
    protected static string $resource = LiberacaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'todos' => Tab::make('Todos')
                ->icon('heroicon-o-list-bullet'),

            'pendentes' => Tab::make('Pendentes')
                ->icon('heroicon-o-clock')
                ->badge(fn () => $this->getResource()::getEloquentQuery()->where('frequencia_professor', 'pendente')->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('frequencia_professor', 'pendente')),

            'falta' => Tab::make('Falta')
                ->icon('heroicon-o-x-circle')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('frequencia_professor', 'falta')),

            'presenca_justificada' => Tab::make('Presença Justificada')
                ->icon('heroicon-o-check-circle')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('frequencia_professor', 'sem_falta')),
        ];
    }
}
