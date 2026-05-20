<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nome')
                    ->required()
                    ->label('Nome Completo'),
                Select::make('cargo')
                    ->options([
                        'admin' => 'Administrador',
                        'aqv' => 'AQV (Coordenação)',
                        'professor' => 'Professor',
                        'portaria' => 'Portaria',
                        'aluno' => 'Aluno',
                    ])
                    ->required()
                    ->label('Cargo / Função'),
                TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('password')
                    ->label('Senha')
                    ->password()
                    ->minLength(8)
                    ->helperText('A senha deve ter no mínimo 8 caracteres.')
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create'),
            ]);
    }
}
