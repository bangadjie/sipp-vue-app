<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Permohonan;

class Category extends Model
{
    // Nama tabel yang digunakan oleh model ini
    protected $table = 'categories';

    // Kolom yang dapat diisi massal
    protected $fillable = [
        'name', // Misalkan tabel categories memiliki kolom name
    ];

    // Definisikan relasi dengan model Permohonan
    public function permohonans()
    {
        return $this->hasMany(Permohonan::class);
    }
}
