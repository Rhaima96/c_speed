<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bilan extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'mv_id',
        'nom',
        'actif',
        'passif',
        'm_actif',
        'm_passif',

    ];

    /**
     * Get the mv that owns the Bilan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mv(): BelongsTo
    {
        return $this->belongsTo(MvComptable::class);
    }
}
