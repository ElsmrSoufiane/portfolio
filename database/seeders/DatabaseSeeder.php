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
         \App\Models\User::factory(10)->create();

         \App\Models\User::factory()->create([
             'name' => 'soufiane lasmae',
             'email' => 'soufianeasmar0@example.com',
             'password'=>'07@12@2004@'
         ]);
    }
}
