<?php

namespace App\Filament\Resources\EscalaProfessores\Pages;

use App\Filament\Resources\EscalaProfessores\EscalaProfessorResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEscalaProfessor extends EditRecord
{
    protected static string $resource = EscalaProfessorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
