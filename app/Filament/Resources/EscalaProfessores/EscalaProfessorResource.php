<?php

namespace App\Filament\Resources\EscalaProfessores;

use App\Filament\Resources\EscalaProfessores\Pages\CreateEscalaProfessor;
use App\Filament\Resources\EscalaProfessores\Pages\EditEscalaProfessor;
use App\Filament\Resources\EscalaProfessores\Pages\ListEscalaProfessores;
use App\Models\EscalaProfessor;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;

class EscalaProfessorResource extends Resource
{
    protected static ?string $model = EscalaProfessor::class;

    protected static ?string $modelLabel = 'Escala / Associação de Professor';
    protected static ?string $pluralModelLabel = 'Escalas de Professores';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('professor_id')
                    ->relationship('professor', 'nome', fn ($query) => $query->where('cargo', 'professor'))
                    ->searchable()
                    ->preload()
                    ->required()
                    ->placeholder('Selecione o professor...')
                    ->label('Professor'),
                Select::make('turma_disciplina_id')
                    ->relationship('turmaDisciplina', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->turma?->nome} - {$record->disciplina?->nome}")
                    ->searchable()
                    ->preload()
                    ->required()
                    ->placeholder('Selecione a turma e disciplina...')
                    ->label('Turma e Disciplina'),
                TextInput::make('periodo')
                    ->required()
                    ->maxLength(50)
                    ->placeholder('Ex: 1º Tempo, 2º Tempo, Matutino...')
                    ->label('Tempo de Aula / Período'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('professor.nome')
                    ->searchable()
                    ->sortable()
                    ->label('Professor'),
                TextColumn::make('turmaDisciplina.turma.nome')
                    ->searchable()
                    ->sortable()
                    ->label('Turma'),
                TextColumn::make('turmaDisciplina.disciplina.nome')
                    ->searchable()
                    ->sortable()
                    ->label('Disciplina'),
                TextColumn::make('periodo')
                    ->searchable()
                    ->sortable()
                    ->label('Tempo / Aula'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEscalaProfessores::route('/'),
            'create' => CreateEscalaProfessor::route('/create'),
            'edit' => EditEscalaProfessor::route('/{record}/edit'),
        ];
    }
}
