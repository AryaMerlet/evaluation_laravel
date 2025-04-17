<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reunion\Reservation;
use App\Models\User;
use App\Models\Reunion\Salle;
use Carbon\Carbon;
use Log;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get the salarie user
        $salarie = User::find(1);

        if (!$salarie) {
            $this->command->info('Salarie user not found. Please run UserSeeder first.');
            return;
        }

        // Get all salles
        $salles = Salle::all();

        if ($salles->isEmpty()) {
            $this->command->info('No salles found. Please run SalleSeeder first.');
            return;
        }

        // Create past reservations (last month)
        $this->createPastReservations($salarie, $salles);

        // Create recent past reservations (last week)
        $this->createRecentPastReservations($salarie, $salles);

        // Create future reservations (next week)
        $this->createFutureReservations($salarie, $salles);

        // Create some reservations for random users to demonstrate room utilization
        $this->createUtilizationData($salles);
    }

    /**
     * Create past reservations for the salarie
     */
    private function createPastReservations($salarie, $salles)
    {
        // Last month reservations
        $dates = [
            Carbon::now()->subMonth()->startOfMonth()->addDays(5),
            Carbon::now()->subMonth()->startOfMonth()->addDays(12),
            Carbon::now()->subMonth()->startOfMonth()->addDays(19),
        ];

        foreach ($dates as $date) {
            Reservation::create([
                'user_id' => $salarie->id,
                'salle_id' => $salles->random()->id,
                'date' => $date->format('Y-m-d'),
                'heure_debut' => '10:00:00',
                'heure_fin' => '12:00:00',
                'motif' => 'Réunion mensuelle',
                'user_id_creation' => 1,
            ]);

            // Add another reservation on some days
            if (rand(0, 1)) {
                Reservation::create([
                    'user_id' => $salarie->id,
                    'salle_id' => $salles->random()->id,
                    'date' => $date->format('Y-m-d'),
                    'heure_debut' => '14:00:00',
                    'heure_fin' => '15:30:00',
                    'motif' => 'Point d\'équipe',
                'user_id_creation' => 1,

                ]);
            }
        }
    }

    /**
     * Create recent past reservations for the salarie
     */
    private function createRecentPastReservations($salarie, $salles)
    {
        // Last week reservations
        $now = Carbon::now();
        $lastWeekStart = Carbon::now()->subWeek()->startOfWeek();

        for ($day = 0; $day < 5; $day++) { // Monday to Friday
            $date = $lastWeekStart->copy()->addDays($day);

            // Skip if this date is in the future
            if ($date->isAfter($now)) {
                continue;
            }

            // Morning reservation
            if (rand(0, 1)) {
                Reservation::create([
                    'user_id' => $salarie->id,
                    'salle_id' => $salles->random()->id,
                    'date' => $date->format('Y-m-d'),
                    'heure_debut' => '09:00:00',
                    'heure_fin' => '10:30:00',
                    'motif' => 'Stand-up quotidien',
                'user_id_creation' => 1,

                ]);
            }

            // Afternoon reservation
            if ($day == 2) { // Wednesday
                Reservation::create([
                    'user_id' => $salarie->id,
                    'salle_id' => $salles->random()->id,
                    'date' => $date->format('Y-m-d'),
                    'heure_debut' => '14:00:00',
                    'heure_fin' => '16:00:00',
                    'motif' => 'Revue de projet',
                'user_id_creation' => 1,

                ]);
            }
        }

        // Add some reservations for earlier today if it's not too late
        if ($now->hour < 12) {
            Reservation::create([
                'user_id' => $salarie->id,
                'salle_id' => $salles->random()->id,
                'date' => $now->format('Y-m-d'),
                'heure_debut' => '08:30:00',
                'heure_fin' => '09:00:00',
                'user_id_creation' => 1,
                'motif' => 'Appel client',
            ]);
        }
    }

    /**
     * Create future reservations for the salarie
     */
    private function createFutureReservations($salarie, $salles)
    {
        // Next week reservations
        $nextWeekStart = Carbon::now()->addWeek()->startOfWeek();

        for ($day = 0; $day < 5; $day++) { // Monday to Friday
            $date = $nextWeekStart->copy()->addDays($day);

            // Create 1-2 reservations per day
            $numReservations = rand(1, 2);

            for ($i = 0; $i < $numReservations; $i++) {
                $startHour = $i == 0 ? rand(9, 11) : rand(13, 16);
                $duration = rand(1, 3);
                $endHour = $startHour + $duration;
                Log::debug("Start hour: $startHour, End hour: $endHour");

                Reservation::create([
                    'user_id' => $salarie->id,
                    'salle_id' => $salles->random()->id,
                    'date' => $date->format('Y-m-d'),
                    'heure_debut' =>  $startHour,
                    'heure_fin' =>  $endHour,
                    'motif' => $this->getRandomMotif(),
                'user_id_creation' => 1,
                ]);
            }
        }

        // Create a few more future reservations for specific purposes
        $twoWeeksFromNow = Carbon::now()->addWeeks(2);

        Reservation::create([
            'user_id' => $salarie->id,
            'salle_id' => $salles->first()->id, // Salle de conférence A
            'date' => $twoWeeksFromNow->format('Y-m-d'),
            'heure_debut' => '10:00:00',
            'heure_fin' => '12:00:00',
                'user_id_creation' => 1,
                'motif' => 'Présentation trimestrielle',
        ]);

        Reservation::create([
            'user_id' => $salarie->id,
            'salle_id' => $salles->get(3)->id, // Salle créative D
            'date' => $twoWeeksFromNow->addDays(2)->format('Y-m-d'),
            'heure_debut' => '14:00:00',
            'heure_fin' => '17:00:00',
                'user_id_creation' => 1,
                'motif' => 'Atelier innovation',
        ]);
    }

    /**
     * Create data to demonstrate room utilization for the admin dashboard
     */
    private function createUtilizationData($salles)
    {
        // Current week data (for admin dashboard)
        $currentWeekStart = Carbon::now()->startOfWeek();

        // Create different utilization patterns for each room
        foreach ($salles as $index => $salle) {
            // Determine how booked this room should be (based on index for variety)
            $bookingLevel = match($index) {
                0 => 'high',    // First room - high utilization
                1 => 'medium',  // Second room - medium utilization
                2 => 'low',     // Third room - low utilization
                3 => 'medium',  // Fourth room - medium utilization
                4 => 'high',    // Fifth room - high utilization
                default => 'medium',
            };

            // Different booking patterns
            $daysToBook = match($bookingLevel) {
                'high' => range(0, 4),    // Book all weekdays
                'medium' => [0, 2, 4],    // Book Mon, Wed, Fri
                'low' => [1, 3],          // Book Tue, Thu
                default => [0, 2, 4],
            };

            // Book the room on certain days
            foreach ($daysToBook as $dayOffset) {
                $date = $currentWeekStart->copy()->addDays($dayOffset);

                // Skip past days
                if ($date->isPast() && !$date->isToday()) {
                    continue;
                }

                // Determine how many bookings per day
                $bookingsPerDay = match($bookingLevel) {
                    'high' => rand(2, 3),
                    'medium' => rand(1, 2),
                    'low' => 1,
                    default => 1,
                };

                // Create the bookings
                $timeSlots = $this->getTimeSlots($bookingsPerDay, $bookingLevel);

                foreach ($timeSlots as $timeSlot) {
                    // Create reservation with random user (for variety)
                    Reservation::create([
                        'user_id' => User::find(1)->id,
                        'salle_id' => $salle->id,
                        'date' => $date->format('Y-m-d'),
                        'heure_debut' => $timeSlot['start'],
                        'heure_fin' => $timeSlot['end'],
                        'user_id_creation' => 1,
                        'motif' => $this->getRandomMotif(),
                    ]);
                }
            }
        }
    }

    /**
     * Get random time slots for bookings
     */
    private function getTimeSlots($count, $bookingLevel)
    {
        $slots = [];

        // Possible start times (hourly from 9 to 16)
        $startTimes = ['09:00:00', '10:00:00', '11:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00'];

        // Shuffle the times for randomness
        shuffle($startTimes);

        // Take the first $count times
        $selectedStartTimes = array_slice($startTimes, 0, $count);
        sort($selectedStartTimes);  // Sort times chronologically

        foreach ($selectedStartTimes as $startTime) {
            $startHour = (int)substr($startTime, 0, 2);

            // Duration depends on booking level
            $duration = match($bookingLevel) {
                'high' => rand(2, 3),
                'medium' => rand(1, 2),
                'low' => 1,
                default => 1,
            };

            $endHour = min($startHour + $duration, 18);  // Don't go past 6pm
            $endTime = sprintf('%02d:00:00', $endHour);

            $slots[] = [
                'start' => $startTime,
                'end' => $endTime
            ];
        }

        return $slots;
    }

    /**
     * Get a random meeting purpose
     */
    private function getRandomMotif()
    {
        $motifs = [
            'Réunion d\'équipe',
            'Point client',
            'Entretien candidat',
            'Formation',
            'Brainstorming',
            'Revue de projet',
            'Point d\'avancement',
            'Démonstration produit',
            'Réunion commerciale',
            'Session de travail',
            'Vidéoconférence',
            'Atelier',
        ];

        return $motifs[array_rand($motifs)];
    }
}
