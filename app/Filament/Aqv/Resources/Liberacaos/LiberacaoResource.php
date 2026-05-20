<?php

namespace App\Filament\Aqv\Resources\Liberacaos;

use App\Filament\Aqv\Resources\Liberacaos\Pages\CreateLiberacao;
use App\Filament\Aqv\Resources\Liberacaos\Pages\EditLiberacao;
use App\Filament\Aqv\Resources\Liberacaos\Pages\ListLiberacaos;
use App\Filament\Aqv\Resources\Liberacaos\Pages\ViewLiberacao;
use App\Filament\Aqv\Resources\Liberacaos\Schemas\LiberacaoForm;
use App\Filament\Aqv\Resources\Liberacaos\Schemas\LiberacaoInfolist;
use App\Filament\Aqv\Resources\Liberacaos\Tables\LiberacaosTable;
use App\Models\Liberacao;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LiberacaoResource extends Resource
{
    protected static ?string $model = Liberacao::class;
    protected static ?string $modelLabel = 'Liberação';
    protected static ?string $pluralModelLabel = 'Liberações';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    public static function form(Schema $schema): Schema
    {
        return LiberacaoForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LiberacaoInfolist::configure($schema);
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
            'create' => CreateLiberacao::route('/create'),
            'view' => ViewLiberacao::route('/{record}'),
            'edit' => EditLiberacao::route('/{record}/edit'),
        ];
    }
}
