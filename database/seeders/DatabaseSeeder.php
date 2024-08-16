<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\Category;
use App\Models\Permohonan;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// use Database\Seeders\Status;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(
            [
            GrupSeeder::class,
            InstansisSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            StatusSeeder::class,
            PermohonanSeeder::class
            ]
        );
    }
}
