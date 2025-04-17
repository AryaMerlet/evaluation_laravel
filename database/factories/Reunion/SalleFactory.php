<?php

namespace Database\Factories\Reunion;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reunion\Salle>
 */
class SalleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'capacity' => fake()->numberBetween(5, 100),
            'surface' => fake()->randomFloat(2, 20, 200),
            'equipments' => fake()->words(3, true),
            'available' => fake()->boolean(),
            'created_at' => fake()->dateTime(),
            'updated_at' => fake()->dateTime(),
            'user_id_creation' => User::factory()->create()->id,
        ];
    }
}
