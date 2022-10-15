<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Search extends Model
{
    protected $fillable = [
        'search_url',
    ];

    /**
     * Get the users associated with the search.
     */
    public function searchUsers(): HasMany
    {
        return $this->hasMany(SearchUser::class);
    }

    /**
     * Get the articles associated with the search.
     */
    public function searchArticles(): HasMany
    {
        return $this->hasMany(SearchArticle::class);
    }
}
