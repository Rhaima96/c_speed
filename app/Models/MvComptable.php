<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MvComptable extends Model
{
    use HasFactory;

    protected $fillable = [
        'num_piece',
        'ref',
        'code',
        'libelle',
        'm_debit',
        'm_credit',
        'tva',
        'user_id',
        'f_id',
        'rec'
    ];

    /**
     * Get the user that owns the MvComptable
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function folder(): BelongsTo
    {
        return $this->belongsTo(FolderComptable::class);
    }

    /**
     * Get the bilan associated with the MvComptable
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function bilan(): HasOne
    {
        return $this->hasOne(Bilan::class, 'mv_id', 'id' );
    }


}
