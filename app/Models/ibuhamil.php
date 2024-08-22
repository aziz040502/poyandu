<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class ibuhamil extends Model
{
       use HasFactory;
    protected $fillable = [
        'nama',
        'suami',
        'nik',
        'TTL',
        'dusun_id',
        'HPHTB',
    ];
    public function dusun(): BelongsTo
    {
        return $this->belongsTo(dusun::class);
    }
    public function periksaibuhamils()
    {
        return $this->hasMany(periksaibuhamil::class);
    }

    public function getNamaAttribute($value)
    {
        return ucwords($value);
    }
}
