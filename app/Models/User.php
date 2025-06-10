<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Database\Seeders\GrupSeeder;
use Database\Seeders\InstansisSeeder;
use Database\Seeders\StatusSeeder;

class User extends Authenticatable
{

    protected $fillable = [
        'name',
        'email',
        'password',
        'grup_id',
        'instanses_id',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function grup()
    {
        return $this->belongsTo(Grup::class);
    }

    public function instanses()
    {
        return $this->belongsTo(Instanses::class);
    }

    public function permohonans()
    {
        return $this->hasMany(Permohonan::class);
    }
}
