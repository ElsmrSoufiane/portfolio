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
            'email' => 'test@example.com',
            'password' => Hash::make('12345@2025'), // <-- Hash the password
        ]);
    }
}