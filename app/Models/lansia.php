<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class lansia extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'nik',
        'TTL',
        'gender',
        'dusun_id'
    ];
    public function dusun(): BelongsTo
    {
        return $this->belongsTo(dusun::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(user::class);
    }
    public function periksalansias()
    {
        return $this->hasMany(periksalansia::class);
    }

    public function getNamaAttribute($value)
    {
        return ucwords($value);
    }
    
}
