<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SearchUser extends Model
{
    protected $fillable = [
        'name',
        'active',
        'search_id',
        'user_id',
    ];

    /**
     * Get the user that owns the search.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get search for this user.
     */
    public function search(): BelongsTo
    {
        return $this->belongsTo(Search::class);
    }

    /**
     * Scope a query to only include enabled searches
     *
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
