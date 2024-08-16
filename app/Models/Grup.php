<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grup extends Model
{

    // Specify the table associated with the model
    protected $table = 'grups';

    // Define fillable attributes
    protected $fillable = [
        'name',
    ];

    // Define relationships if needed
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
