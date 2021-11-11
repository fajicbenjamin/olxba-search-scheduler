<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SearchArticle extends Model
{
    protected $fillable = [
        'name',
        'image_url',
        'article_id',
        'search_id',
    ];

    public $timestamps = true;

    /**
     * Get the search that owns the article.
     */
    public function search(): BelongsTo
    {
        return $this->belongsTo(Search::class);
    }
}
