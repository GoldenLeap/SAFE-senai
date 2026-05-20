<?php

namespace Database\Factories;

use App\Models\Liberacao;
use App\Models\EscalaProfessor;
use App\Models\USer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Liberacao>
 */
class LiberacaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'aluno_id' => User::factory()->create(['cargo' => 'aluno'])->id,
            'aqv_id' => User::factory()->create(['cargo' => 'aqv'])->id,
            'escala_professor_id' => EscalaProfessor::factory(),
            'tipo' => $this->faker->randomElement(['saida', 'entrada']),
            'frequencia_professor' => 'pendente', // Começa pendente para o prof testar
            'status_portaria' => $this->faker->randomElement(['aguardando', 'liberado']),
            'horario_previsto' => $this->faker->time('H:i'),
            'horario_real' => null,
            'observacao' => $this->faker->sentence(),
        ];
    }
}
