<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Statuses;
use App\Models\Instanses;

class Permohonan extends Model
{
    public $timestamps = true;
    // Nama tabel yang digunakan oleh model ini
    protected $table = 'permohonans';

    // Kolom yang dapat diisi massal
    protected $fillable = [
        'user_id',
        'instanses_id',
        'category_id',
        'name',
        'deskripsi',
        'status_id',
    ];

    // Definisikan relasi dengan model Instanses
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function instanses()
    {
        return $this->belongsTo(Instanses::class);
    }

    // Definisikan relasi dengan model Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Definisikan relasi dengan model Status
    public function status()
    {
        return $this->belongsTo(Statuses::class);
    }
}
