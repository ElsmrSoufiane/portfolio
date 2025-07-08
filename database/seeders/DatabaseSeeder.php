<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; // <-- Add this

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'soufiane lasmae',
            'email' => 'soufianeasmar0@example.com',
            'password' => Hash::make('07@12@2004@'), // <-- Hash the password
        ]);
    }
}