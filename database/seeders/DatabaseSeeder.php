<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@tarmiz.ma'], // Condition de recherche
            [
                'first_name' => 'Admin',
                'last_name' => 'Root',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );
        $this->call(GlobalSettingsSeeder::class);
        $this->call(SliderSeeder::class);
        $this->call(VilleSeeder::class);

    }
}
