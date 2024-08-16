<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('statuses')->insert([
            [
                'name' => 'Telah dikirim',
                'deskripsi' => 'Sedang menunggu Proses'
            ],
            [
                'name' => 'Telah diproses',
                'deskripsi' => 'Sedang menunggu Persetujuan'
            ],
            [
                'name' => 'Telah disetujui',
                'deskripsi'  => 'Laporan anda telah di setujui'
            ],
        ]);
    }
}
