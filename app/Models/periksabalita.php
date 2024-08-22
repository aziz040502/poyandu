<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class periksabalita extends Model
{
    use HasFactory;
    use HasFactory;

    protected $fillable = [
        'balita_id',
        'tanggal_lahir',
        'usia',
        'status',
        'BB',
        'TB',
        'lila',
        'menyusuidini',
        'lika',
        'rujukan',
        'imunisasi',
        'PMTpemulihan',
        'vitamin',
        'obatcacing',
        'is_visible',
    ];
    protected $casts = [
        'is_visible' => 'boolean',
        'menyusuidini' => 'boolean',
    ];
    public function balita(): BelongsTo
    {
        return $this->belongsTo(balita::class);
    }
}
