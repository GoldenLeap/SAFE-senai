<?php

namespace App\Filament\Professor\Resources\Liberacaos\Pages;

use App\Filament\Professor\Resources\Liberacaos\LiberacaoResource;
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
