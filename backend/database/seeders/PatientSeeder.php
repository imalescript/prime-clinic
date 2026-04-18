<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
public function run(): void
{
    \App\Models\Patient::factory()->count(50)->create();
}
}
