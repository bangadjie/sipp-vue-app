<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Permohonan;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Statuses extends Model
{
    protected $table = 'statuses';

    protected $fillable = [
        'name',
    ];

    // public function User()
    // {
    //     return $this->belongsTo(UserSeeder::class, 'User_id');
    // }

    public function permohonans()
    {
        return $this->hasMany(Permohonan::class);
    }
}
