<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstansisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('instanses')->insert([

            ['name' => 'Sekretariat Daerah'],
            ['name' => 'Dinas Komunikasi dan Informastika'],
            ['name' => 'Dinas Pariwisata'],
        ]);
    }
}
