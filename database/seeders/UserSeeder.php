<?php

namespace Database\Seeders;

use App\Models\User;
use Bouncer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create salarie user
        $user = User::firstOrCreate(
            ['email' => 'testuser@laravel.com'],
            [
                'first_name' => 'test',
                'last_name' => 'user',
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ]
        );
        Bouncer::assign('salarie')->to($user);

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'testadmin@laravel.com'],
            [
                'first_name' => 'test',
                'last_name' => 'admin',
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ]
        );
        Bouncer::assign('admin')->to($admin);
    }
}
