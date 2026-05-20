<?php

namespace App\Filament\Aqv\Resources\Liberacaos\Pages;

use App\Filament\Aqv\Resources\Liberacaos\LiberacaoResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditLiberacao extends EditRecord
{
    protected static string $resource = LiberacaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
