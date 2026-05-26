<?php

namespace App\Observers;

use App\Mail\TesteMail;
use App\Models\Liberacao;
use App\Models\LiberacaoHistorico;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class LiberacaoObserver
{
    /**
     * Envia uma notificação por e-mail.
     */
    private function enviarEmail(string $destinatario, string $assunto, string $corpo): void
    {
        try {
            Mail::send([], [], function ($message) use ($destinatario, $assunto, $corpo) {
                $message->to($destinatario)
                        ->subject($assunto)
                        ->html($corpo);
            });
        } catch (\Exception $e) {
            logger()->error("Falha ao enviar e-mail para {$destinatario}: " . $e->getMessage());
        }
    }

    /**
     * Handle the Liberacao "created" event.
     */
    public function created(Liberacao $liberacao): void
    {
        // Criar registro de auditoria
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

        // Notificar o Professor da escala letiva
        $professor = $liberacao->escalaProfessor?->professor;
        if ($professor) {
            $titulo = 'Nova Liberação de Aluno';
            $corpo = "O aluno <strong>{$alunoNome}</strong> ({$turmaNome}) tem uma liberação cadastrada para as <strong>{$horario}</strong> na aula de {$disciplinaNome}.";

            Notification::make()
                ->title($titulo)
                ->body($corpo)
                ->info()
                ->sendToDatabase($professor);

            if (!empty($professor->email)) {
                $this->enviarEmail($professor->email, $titulo, $corpo);
            }
        }

        // Notificar todos da Portaria
        $portariaStaff = User::where('cargo', 'portaria')->get();
        foreach ($portariaStaff as $guard) {
            $titulo = 'Novo Aluno Aguardando no Portão';
            $corpo = "O aluno <strong>{$alunoNome}</strong> ({$turmaNome}) está autorizado a sair/entrar às <strong>{$horario}</strong>.";

            Notification::make()
                ->title($titulo)
                ->body($corpo)
                ->warning()
                ->sendToDatabase($guard);

            if (!empty($guard->email)) {
                $this->enviarEmail($guard->email, $titulo, $corpo);
            }
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

        // Verificar se houve liberação física na Portaria
        if ($liberacao->wasChanged('status_portaria') && $liberacao->status_portaria === 'liberado') {
            LiberacaoHistorico::create([
                'liberacao_id' => $liberacao->id,
                'user_id' => auth()->id() ?? 1,
                'acao' => 'liberado_portaria',
                'descricao' => 'A entrada/saída física do aluno foi autorizada e validada no portão pela portaria.',
            ]);

            // Notificar o Professor
            if ($professor) {
                $titulo = 'Aluno Liberado no Portão';
                $corpo = "O aluno <strong>{$alunoNome}</strong> foi liberado e saiu/entrou na portaria às <strong>{$horarioAtual}</strong>.";

                Notification::make()
                    ->title($titulo)
                    ->body($corpo)
                    ->success()
                    ->sendToDatabase($professor);

                if (!empty($professor->email)) {
                    $this->enviarEmail($professor->email, $titulo, $corpo);
                }
            }

            // Notificar toda a Coordenação (AQV)
            $aqvStaff = User::where('cargo', 'aqv')->get();
            foreach ($aqvStaff as $coord) {
                $titulo = 'Saída Concluída na Portaria';
                $corpo = "O aluno <strong>{$alunoNome}</strong> foi oficialmente liberado no portão às <strong>{$horarioAtual}</strong>.";

                Notification::make()
                    ->title($titulo)
                    ->body($corpo)
                    ->success()
                    ->sendToDatabase($coord);

                if (!empty($coord->email)) {
                    $this->enviarEmail($coord->email, $titulo, $corpo);
                }
            }
        }

        // Verificar se o Professor atualizou a Frequência/Chamada
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
                $titulo = "Chamada Atualizada: {$statusLabel}";
                $corpo = "O professor <strong>{$professor?->nome}</strong> marcou <strong>{$statusLabel}</strong> para o aluno <strong>{$alunoNome}</strong>.";

                Notification::make()
                    ->title($titulo)
                    ->body($corpo)
                    ->info()
                    ->sendToDatabase($coord);

                if (!empty($coord->email)) {
                    $this->enviarEmail($coord->email, $titulo, $corpo);
                }
            }
        }
    }
}
