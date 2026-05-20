<?php

namespace App\Filament\Professor\Resources\Liberacaos\Pages;

use App\Filament\Professor\Resources\Liberacaos\LiberacaoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLiberacao extends EditRecord
{
    protected static string $resource = LiberacaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
