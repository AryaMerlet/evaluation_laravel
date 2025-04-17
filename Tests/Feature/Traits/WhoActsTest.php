<?php

namespace Tests\Unit\Traits;

use App\Models\Reunion\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WhoActsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_creation_relationship()
    {
        $user = User::factory()->create();
        $reservation = reservation::factory()->create([
            'user_id_creation' => $user->id,
        ]);

        $this->assertInstanceOf(User::class, $reservation->userCreation);
        $this->assertEquals($user->id, $reservation->userCreation->id);
    }

    public function test_user_modification_relationship()
    {
        $user = User::factory()->create();
        $reservation = reservation::factory()->create([
            'user_id_modification' => $user->id,
        ]);

        $this->assertInstanceOf(User::class, $reservation->userModification);
        $this->assertEquals($user->id, $reservation->userModification->id);
    }

    public function test_user_suppression_relationship()
    {
        $user = User::factory()->create();
        $reservation = reservation::factory()->create([
            'user_id_suppression' => $user->id,
        ]);

        $this->assertInstanceOf(User::class, $reservation->userSuppression);
        $this->assertEquals($user->id, $reservation->userSuppression->id);
    }
}
