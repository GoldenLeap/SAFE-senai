<?php

namespace App\Filament\Resources\EscalaProfessores\Pages;

use App\Filament\Resources\EscalaProfessores\EscalaProfessorResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEscalaProfessores extends ListRecords
{
    protected static string $resource = EscalaProfessorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
