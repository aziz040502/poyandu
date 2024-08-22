<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class balita extends Model
{

    use HasFactory;

    protected $fillable = [
        'nama',
        'nik',
        'TTL',
        'age',
        'gender',
        'ayah',
        'ibu',
        'dusun_id',
    ];
    public function dusun(): BelongsTo
    {
        return $this->belongsTo(dusun::class);
    }
    public function periksabalitas()
    {
        return $this->hasMany(Periksabalita::class);
    }

    public function getNamaAttribute($value)
    {
        return ucwords($value);
    }
    public function age(): Attribute
    {
        return Attribute::make(
            get: fn() => Carbon::parse($this->TTL)->age,
        );
    }
}
