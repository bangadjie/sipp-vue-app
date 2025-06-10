<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PermohonanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permohonans')->insert([
            [
                'user_id' => 1,
                'instanses_id' => 1,
                'category_id' => 1,
                'name' => 'adjie',
                'deskripsi' => 'Kejahatan',
                'status_id' => 1,
            ],
            [
                'user_id' => 2,
                'instanses_id' => 2,
                'category_id' => 2,
                'name' => 'adjie',
                'deskripsi' => 'Kejahatan',
                'status_id' => 2,
            ],
            [
                'user_id' => 3,
                'instanses_id' => 3,
                'category_id' => 3,
                'name' => fake()->name(),
                'deskripsi' => 'Bencana Alam',
                'status_id' => 3,
            ],
        ]);
    }
}
