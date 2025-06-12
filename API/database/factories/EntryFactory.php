<?php

namespace Database\Factories;

use App\Enums\Tipo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entry>
 */
class EntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'data' => now()->format('d/m/Y'),
            'descricao' => $this->faker->paragraph(),
            'tipo' => $this->faker->randomElement(Tipo::values()),
            'valor' => $this->faker->randomFloat(2, 1, 1000),
        ];
    }
}
