<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Database\Seeders\UserSeeder;
use App\Models\Permohonan;


class Instanses extends Model
{
    // Nama tabel yang digunakan oleh model ini
    protected $table = 'instanses';

    // Kolom yang dapat diisi massal
    protected $fillable = [
        'name', // Misalkan tabel instanses memiliki kolom name
    ];

    public function User()
    {
        return $this->hasMany(UserSeeder::class);
    }

    public function permohonans()
    {
        return $this->hasMany(Permohonan::class);
    }
}
