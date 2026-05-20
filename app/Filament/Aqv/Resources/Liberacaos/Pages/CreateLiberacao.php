<?php

namespace App\Filament\Aqv\Resources\Liberacaos\Pages;

use App\Filament\Aqv\Resources\Liberacaos\LiberacaoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLiberacao extends CreateRecord
{
    protected static string $resource = LiberacaoResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['aqv_id'] = auth()->id();
        return $data;
    }
}
