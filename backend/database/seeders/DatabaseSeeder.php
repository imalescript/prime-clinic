<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
public function run(): void
{
    $user = \App\Models\User::factory()->create([
        'name' => 'Alexander Rivero',
        'email' => 'admin@test.com',
        'password' => bcrypt('password'),
    ]);

    \App\Models\Patient::factory()
        ->count(50)
        ->create([
            'user_id' => $user->id
        ]);
        
    \App\Models\SurgeryType::create(['name' => 'Apendicectomía', 'description' => '...']);
    \App\Models\SurgeryType::create(['name' => 'Colecistectomía', 'description' => '...']);
}
}
