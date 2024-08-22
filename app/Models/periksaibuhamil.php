<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class periksaibuhamil extends Model
{
    use HasFactory;
    protected $fillable = [
        'ibuhamil_id',
        'HPHT',
        'UK',
        'PTP',
        'BB',
        'TB',
        'lila',
        'TDSI',
        'TDDI',
        'TFU',
        'DJJ',
        'LJ',
        'HB',
        'GDS',
        'PU',
        'TT',
        'TTD',
        'PMTpemulihan',
        'rujukan',
        'bukuKIA',
    ];
    protected $casts = [
        'bukuKIA' => 'boolean',
    ];
    public function ibuhamil(): BelongsTo
    {
        return $this->belongsTo(ibuhamil::class);
    }
}
