<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class periksalansia extends Model
{
    use HasFactory;
    protected $fillable = [
        'lansia_id', 'BB', 'TB', 'LP', 'TDSI', 'TDDI', 'nadi', 'GD', 'AS', 'CHOL', 'GEP', 'SGDS', 'koghnitif', 'AMT', 'RJ', 'ADL', 'kemandirian', 'kencing', 'mata', 'telinga',
    ];
    public function lansia(): BelongsTo
    {
        return $this->belongsTo(lansia::class);
    }
}
