<?php

namespace Database\Factories\Reunion;

use App\Models\Reunion\Salle;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reunion\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create()->id,
            'salle_id' => Salle::factory()->create()->id,
            'date' => fake()->date(),
            'heure_debut' => fake()->time('H:i'),
            'heure_fin' => fake()->time('H:i'),
            'user_id_creation' => User::factory()->create()->id,
        ];
    }
}
