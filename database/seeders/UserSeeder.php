<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'superadmin',
                'email' => 'superadmin@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'grup_id' => 1,
                'instanses_id' => 1,
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'grup_id' => 2,
                'instanses_id' => 2,
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'user',
                'email' => 'user@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'grup_id' => 3,
                'instanses_id' => 3,
                'remember_token' => Str::random(10),
            ],
        ]);
    }
}

// [
//     'name' => fake()->name(),
//     'email' => fake()->unique()->safeEmail(),
//     'email_verified_at' => now(),
//     'password' => Hash::make('password'),
//     'grup_id' => 3,
//     'instanses_id' => 3,
//     'remember_token' => Str::random(10),
// ],
