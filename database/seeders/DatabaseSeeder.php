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
         

         DB::table('users')->insert([
             'name' => 'soufiane lasmae',
             'email' => 'soufianeasmar0@example.com',
             'password'=>'07@12@2004@'
         ]);
    }
}
