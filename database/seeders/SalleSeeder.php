<?php

namespace Database\Seeders;

use App\Models\Reunion\Salle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $salles = [
            [
                'name' => 'Salle de conférence A',
                'capacity' => 30,
                'surface' => 50,
                'description' => 'Grande salle de conférence avec équipement audiovisuel',
                'equipments' => 'Projecteur, Système audio, Tableau blanc, Wifi',
                'available' => true,
                'user_id_creation' => 1,
            ],
            [
                'name' => 'Salle de réunion B',
                'capacity' => 12,
                'surface' => 25,
                'description' => 'Salle de réunion moyenne avec table ovale',
                'equipments' => 'Écran TV, Webcam, Tableau blanc, Wifi',
                'available' => true,
                'user_id_creation' => 1,

            ],
            [
                'name' => 'Bureau individuel C',
                'capacity' => 4,
                'surface' => 15,
                'description' => 'Petit bureau pour entretiens ou petites réunions',
                'equipments' => 'Wifi, Tableau blanc portable',
                'available' => true,
                'user_id_creation' => 1,

            ],
            [
                'name' => 'Salle créative D',
                'capacity' => 15,
                'surface' => 30,
                'description' => 'Espace collaboratif pour brainstorming',
                'equipments' => 'Tableaux muraux, Post-its, Fauteuils confortables, Wifi',
                'available' => true,
                'user_id_creation' => 1,

            ],
            [
                'name' => 'Amphithéâtre E',
                'capacity' => 50,
                'surface' => 100,
                'description' => 'Grand amphithéâtre pour présentations importantes',
                'equipments' => 'Projecteur HD, Système son Dolby, Pupitres, Wifi',
                'available' => true,
                'user_id_creation' => 1,

            ],
        ];

        foreach ($salles as $salle) {
            Salle::firstOrCreate(['name' => $salle['name']], $salle);
        }
    }
}
