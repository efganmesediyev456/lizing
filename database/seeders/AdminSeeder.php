<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(!User::where('email','admin@gmail.com')->exists()){
            User::create([
                "email"=>"admin@gmail.com",
                "surname"=>"admin",
                "password"=> Hash::make("Az12345678"),
                "name"=>"admin",
                "is_super"=>1
            ]);
        }
    }
}
