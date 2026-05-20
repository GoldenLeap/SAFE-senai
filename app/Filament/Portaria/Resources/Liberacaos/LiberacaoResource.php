<?php

namespace App\Filament\Portaria\Resources\Liberacaos;

use App\Filament\Portaria\Resources\Liberacaos\Pages\CreateLiberacao;
use App\Filament\Portaria\Resources\Liberacaos\Pages\EditLiberacao;
use App\Filament\Portaria\Resources\Liberacaos\Pages\ListLiberacaos;
use App\Filament\Portaria\Resources\Liberacaos\Schemas\LiberacaoForm;
use App\Filament\Portaria\Resources\Liberacaos\Tables\LiberacaosTable;
use App\Models\Liberacao;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

use Illuminate\Database\Eloquent\Builder;

class LiberacaoResource extends Resource
{
    protected static ?string $model = Liberacao::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;
    
    protected static ?string $modelLabel = 'Liberação';
    protected static ?string $pluralModelLabel = 'Liberações Pendentes';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('status_portaria', 'aguardando');
    }

    public static function form(Schema $schema): Schema
    {
        return LiberacaoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LiberacaosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLiberacaos::route('/'),
        ];
    }
}
