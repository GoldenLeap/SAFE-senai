<?php

namespace Database\Factories;
use App\Models\TurmaDisciplina;
use App\Models\User;
use App\Models\EscalaProfessor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EscalaProfessor>
 */
class EscalaProfessorFactory extends Factory
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
            'professor_id' => User::factory()->create(['cargo' => 'professor'])->id,
            'turma_disciplina_id' => TurmaDisciplina::inRandomOrder(42)->first()?->id ?? 1,
            'periodo' => $this->faker->randomElement(['1º Tempo', '2º Tempo', 'Periodo inteiro']),



        ];
    }
}
