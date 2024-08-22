<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dusun extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];

    public function getNamaAttribute($value)
    {
        return ucwords($value);
    }
}
