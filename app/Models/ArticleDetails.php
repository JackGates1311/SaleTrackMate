<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static find($id)
 */
class ArticleDetails extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $table = "article_details";

    protected $fillable = ['article_id', 'url', 'category', 'supplier', 'country_origin', 'country_origin_code',
        'weight', 'dimensions', 'color'];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class, 'article_id', 'id');
    }
}
