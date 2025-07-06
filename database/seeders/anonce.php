<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class anonce extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       DB::table("annonces")->insert([
        "titre"=>"zzz",
        "description"=>"aaa",
        "type"=>"zzz",
        "ville"=>"ddqq",
        "superficie"=>166,
    "etat"=>"zzz",
    "prix"=>111,
    
       ]);
    }
}
