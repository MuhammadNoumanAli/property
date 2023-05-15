<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

         \App\Models\Agency::factory()->create([
             'name' => 'Agency User',
             'email' => 'agency@gmail.com',
         ]);

        \App\Models\Admin::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@gmail.com',
        ]);

        \App\Models\Superadmin::factory()->create([
            'name' => 'Test User',
            'email' => 'superadmin@gmail.com',
        ]);
    }
}
