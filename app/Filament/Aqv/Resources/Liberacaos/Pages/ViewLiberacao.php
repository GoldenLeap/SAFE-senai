<?php

namespace App\Filament\Aqv\Resources\Liberacaos\Pages;

use App\Filament\Aqv\Resources\Liberacaos\LiberacaoResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLiberacao extends ViewRecord
{
    protected static string $resource = LiberacaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
