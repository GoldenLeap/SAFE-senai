<?php

namespace App\Observers;

use App\Models\Liberacao;
use App\Models\LiberacaoHistorico;
use App\Models\User;
use Filament\Notifications\Notification;

class LiberacaoObserver
{
    /**
     * Handle the Liberacao "created" event.
     */
    public function created(Liberacao $liberacao): void
    {
        // 1. Criar registro de auditoria
        LiberacaoHistorico::create([
            'liberacao_id' => $liberacao->id,
            'user_id' => auth()->id() ?? $liberacao->aqv_id,
            'acao' => 'criado',
            'descricao' => 'A liberação foi criada pela coordenação (AQV).',
        ]);

        // Carregar relações necessárias
        $liberacao->load(['aluno', 'escalaProfessor.professor', 'escalaProfessor.turmaDisciplina.turma', 'escalaProfessor.turmaDisciplina.disciplina']);

        $alunoNome = $liberacao->aluno?->nome ?? 'Aluno';
        $turmaNome = $liberacao->escalaProfessor?->turmaDisciplina?->turma?->nome ?? 'Turma';
        $disciplinaNome = $liberacao->escalaProfessor?->turmaDisciplina?->disciplina?->nome ?? 'Disciplina';
        $horario = substr($liberacao->horario_previsto, 0, 5);

        // 2. Notificar o Professor da escala letiva
        $professor = $liberacao->escalaProfessor?->professor;
        if ($professor) {
            Notification::make()
                ->title('Nova Liberação de Aluno 🛡️')
                ->body("O aluno <strong>{$alunoNome}</strong> ({$turmaNome}) tem uma liberação cadastrada para as <strong>{$horario}</strong> na aula de {$disciplinaNome}.")
                ->info()
                ->toDatabase($professor);
        }

        // 3. Notificar todos da Portaria
        $portariaStaff = User::where('cargo', 'portaria')->get();
        foreach ($portariaStaff as $guard) {
            Notification::make()
                ->title('Novo Aluno Aguardando no Portão 🚪')
                ->body("O aluno <strong>{$alunoNome}</strong> ({$turmaNome}) está autorizado a sair/entrar às <strong>{$horario}</strong>.")
                ->warning()
                ->sendToDatabase($guard);
        }
    }

    /**
     * Handle the Liberacao "updated" event.
     */
    public function updated(Liberacao $liberacao): void
    {
        $liberacao->load(['aluno', 'escalaProfessor.professor', 'escalaProfessor.turmaDisciplina.turma']);

        $alunoNome = $liberacao->aluno?->nome ?? 'Aluno';
        $professor = $liberacao->escalaProfessor?->professor;
        $horarioAtual = now()->format('H:i');

        // 1. Verificar se houve liberação física na Portaria
        if ($liberacao->wasChanged('status_portaria') && $liberacao->status_portaria === 'liberado') {
            LiberacaoHistorico::create([
                'liberacao_id' => $liberacao->id,
                'user_id' => auth()->id() ?? 1,
                'acao' => 'liberado_portaria',
                'descricao' => 'A entrada/saída física do aluno foi autorizada e validada no portão pela portaria.',
            ]);

            // Notificar o Professor
            if ($professor) {
                Notification::make()
                    ->title('Aluno Liberado no Portão ✅')
                    ->body("O aluno <strong>{$alunoNome}</strong> foi liberado e saiu/entrou na portaria às <strong>{$horarioAtual}</strong>.")
                    ->success()
                    ->sendToDatabase($professor);
            }

            // Notificar toda a Coordenação (AQV)
            $aqvStaff = User::where('cargo', 'aqv')->get();
            foreach ($aqvStaff as $coord) {
                Notification::make()
                    ->title('Saída Concluída na Portaria 🚪')
                    ->body("O aluno <strong>{$alunoNome}</strong> foi oficialmente liberado no portão às <strong>{$horarioAtual}</strong>.")
                    ->success()
                    ->sendToDatabase($coord);
            }
        }

        // 2. Verificar se o Professor atualizou a Frequência/Chamada
        if ($liberacao->wasChanged('frequencia_professor')) {
            $statusLabel = $liberacao->frequencia_professor === 'falta' ? 'Falta' : 'Presença Justificada';
            $acao = $liberacao->frequencia_professor === 'falta' ? 'falta_aplicada' : 'presenca_justificada';
            $descricao = $liberacao->frequencia_professor === 'falta'
                ? "O professor registrou a falta do aluno em sala de aula."
                : "O professor justificou a presença/falta do aluno na chamada.";

            LiberacaoHistorico::create([
                'liberacao_id' => $liberacao->id,
                'user_id' => auth()->id() ?? 1,
                'acao' => $acao,
                'descricao' => $descricao,
            ]);

            // Notificar toda a Coordenação (AQV)
            $aqvStaff = User::where('cargo', 'aqv')->get();
            foreach ($aqvStaff as $coord) {
                Notification::make()
                    ->title("Chamada Atualizada: {$statusLabel} 📝")
                    ->body("O professor <strong>{$professor?->nome}</strong> marcou <strong>{$statusLabel}</strong> para o aluno <strong>{$alunoNome}</strong>.")
                    ->info()
                    ->sendToDatabase($coord);
            }
        }
    }
}
