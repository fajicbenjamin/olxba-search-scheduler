<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Search extends Model
{
    protected $fillable = [
        'name',
        'search_url',
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
     * Get the articles associated with the search.
     */
    public function searchArticles(): HasMany
    {
        return $this->hasMany(SearchArticle::class);
    }
}
