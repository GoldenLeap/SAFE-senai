<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Turma;
use App\Models\Disciplina;
use App\Models\EscalaProfessor;
use App\Models\Liberacao;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // CRIAR AS TURMAS E DISCIPLINAS REAIS
        $turmaInfo = Turma::create(['nome' => '3º Ano Informática', 'periodo' => 'Noturno']);
        $turmaAdm = Turma::create(['nome' => '1º Ano Administração', 'periodo' => 'Matutino']);

        $disciplinaWeb = Disciplina::create(['nome' => 'Programação Web']);
        $disciplinaFinancas = Disciplina::create(['nome' => 'Finanças Corporativas']);

        // Cria a grade curricular na tabela pivô (turma_disciplina)
        $gradeWebId = DB::table('turma_disciplinas')->insertGetId([
            'turma_id' => $turmaInfo->id,
            'disciplina_id' => $disciplinaWeb->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $gradeFinancasId = DB::table('turma_disciplinas')->insertGetId([
            'turma_id' => $turmaAdm->id,
            'disciplina_id' => $disciplinaFinancas->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        // CRIAR OS USUÁRIOS FIXOS DO SISTEMA


        // AQV Fixo
        $aqv = User::factory()->create([
            'nome' => 'Ana Coordenação (AQV)',
            'email' => 'aqv@escola.com',
            'cargo' => 'aqv',
            'senha' => bcrypt('senha123'),
        ]);

        // Professor Fixo
        $professorCarlos = User::factory()->create([
            'nome' => 'Professor Carlos',
            'email' => 'professor@escola.com',
            'cargo' => 'professor',
            'senha' => bcrypt('senha123'),
        ]);

        // Porteiro Fixo
        User::factory()->create([
            'nome' => 'Seu Jorge (Portaria)',
            'email' => 'portaria@escola.com',
            'cargo' => 'portaria',
            'senha' => bcrypt('senha123'),
        ]);

        // Aluno Fixo (O João)
        $alunoJoao = User::factory()->create([
            'nome' => 'João Aluno de Teste',
            'email' => 'aluno@escola.com',
            'cargo' => 'aluno',
            'senha' => bcrypt('senha123'),
        ]);

        // MATRICULAR O JOÃO NA TURMA DO PROFESSOR CARLOS
        DB::table('aluno_turma')->insert([
            'aluno_id' => $alunoJoao->id,
            'turma_id' => $turmaInfo->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        // CRIAR A ESCALA DO PROFESSOR

        // Vincula o Professor Carlos à turma de Informática no 1º Período
        $escalaCarlos = EscalaProfessor::create([
            'professor_id' => $professorCarlos->id,
            'turma_disciplina_id' => $gradeWebId,
            'periodo' => '1º Tempo'
        ]);


        //  ENCHER O BANCO COM OUTROS ALUNOS

        // Cria 30 alunos fakes e joga eles aleatoriamente nas turmas
        User::factory(30)->create(['cargo' => 'aluno'])->each(function ($aluno) use ($turmaInfo, $turmaAdm) {
            $turmaSorteada = rand(1, 2) == 1 ? $turmaInfo->id : $turmaAdm->id;

            DB::table('aluno_turma')->insert([
                'aluno_id' => $aluno->id,
                'turma_id' => $turmaSorteada,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });



        //  GERAR LIBERAÇÕES DE TESTE REAIS PARA O JOÃO
        // Criando 2 liberações fakes onde o João saiu mais cedo da aula do Carlos
        Liberacao::create([
            'aluno_id' => $alunoJoao->id,
            'aqv_id' => $aqv->id,
            'escala_professor_id' => $escalaCarlos->id,
            'tipo' => 'saida',
            'frequencia_professor' => 'pendente',
            'status_portaria' => 'liberado',
            'horario_previsto' => '21:00:00',
            'horario_real' => '21:05:00',
            'observacao' => 'Dor de dente forte, liberado para ir ao dentista.',
            'created_at' => now()->subDays(1), // Ontem
        ]);

        Liberacao::create([
            'aluno_id' => $alunoJoao->id,
            'aqv_id' => $aqv->id,
            'escala_professor_id' => $escalaCarlos->id,
            'tipo' => 'saida',
            'frequencia_professor' => 'pendente',
            'status_portaria' => 'aguardando', // Uma que ainda está esperando no portão hoje!
            'horario_previsto' => '22:15:00',
            'horario_real' => null,
            'observacao' => 'Ônibus da prefeitura passa mais cedo hoje.',
            'created_at' => now(),
        ]);
    }
}
