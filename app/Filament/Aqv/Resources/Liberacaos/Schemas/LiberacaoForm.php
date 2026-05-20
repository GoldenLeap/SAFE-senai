<?php

namespace App\Filament\Aqv\Resources\Liberacaos\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class LiberacaoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('aluno_id')
                    ->relationship('aluno', 'nome', fn ($query) => $query->where('cargo', 'aluno'))
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live()
                    ->placeholder('Selecione ou digite o nome do aluno...')
                    ->helperText('Digite para pesquisar pelo nome completo do estudante.')
                    ->label('Aluno'),
                Select::make('escala_professor_id')
                    ->relationship(
                        name: 'escalaProfessor',
                        titleAttribute: 'periodo',
                        modifyQueryUsing: function ($query, callable $get) {
                            $query->select('escala_professores.*')
                                ->join('users as professors', 'escala_professores.professor_id', '=', 'professors.id')
                                ->join('turma_disciplinas', 'escala_professores.turma_disciplina_id', '=', 'turma_disciplinas.id')
                                ->join('turmas', 'turma_disciplinas.turma_id', '=', 'turmas.id')
                                ->join('disciplinas', 'turma_disciplinas.disciplina_id', '=', 'disciplinas.id')
                                ->with(['professor', 'turmaDisciplina.turma', 'turmaDisciplina.disciplina']);

                            $alunoId = $get('aluno_id');
                            if ($alunoId) {
                                $query->whereHas('turmaDisciplina.turma.alunos', function ($q) use ($alunoId) {
                                    $q->where('users.id', $alunoId);
                                });
                            } else {
                                $query->whereRaw('1 = 0');
                            }
                        }
                    )
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->professor?->nome} - {$record->turmaDisciplina?->turma?->nome} ({$record->turmaDisciplina?->disciplina?->nome}) - {$record->periodo}")
                    ->required()
                    ->searchable(['escala_professores.periodo', 'professors.nome', 'turmas.nome', 'disciplinas.nome'])
                    ->preload()
                    ->disabled(fn (callable $get) => !$get('aluno_id'))
                    ->placeholder(fn (callable $get) => $get('aluno_id') ? 'Digite Professor, Turma, Disciplina ou Tempo...' : 'Selecione o aluno primeiro...')
                    ->helperText(fn (callable $get) => $get('aluno_id')
                        ? 'Permite busca avançada instantânea filtrada apenas para os professores deste aluno.'
                        : 'Você deve selecionar um aluno para poder escolher a escala de aula correspondente.')
                    ->label('Escala/Tempo do Professor'),
                Select::make('tipo')
                    ->options([
                        'saida' => 'Saída Antecipada',
                        'entrada' => 'Entrada Tardia',
                    ])
                    ->required()
                    ->label('Tipo de Liberação'),
                TimePicker::make('horario_previsto')
                    ->required()
                    ->label('Horário Previsto'),
                Textarea::make('observacao')
                    ->maxLength(500)
                    ->placeholder('Escreva o motivo detalhado da liberação (Opcional - Máx. 500 caracteres)')
                    ->columnSpanFull()
                    ->label('Observação / Motivo'),
            ]);
    }
}
