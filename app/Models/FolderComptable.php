<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FolderComptable extends Model
{
    use HasFactory;
    protected $fillable = [
        'num_f',
        'name',
        'user_id'
    ];

    /**
     * Get the user that owns the FolderComptable
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the mvs for the FolderComptable
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mvs(): HasMany
    {
        return $this->hasMany(MvComptable::class, 'f_id', 'id');
    }
}
