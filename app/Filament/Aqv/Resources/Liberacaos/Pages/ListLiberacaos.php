<?php

namespace App\Filament\Aqv\Resources\Liberacaos\Pages;

use App\Filament\Aqv\Resources\Liberacaos\LiberacaoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLiberacaos extends ListRecords
{
    protected static string $resource = LiberacaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
