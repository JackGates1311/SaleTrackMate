<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static find($id)
 */
class Article extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $table = "articles";
    protected $fillable = ['company_id', 'article_id', 'serial_num', 'name', 'unit', 'min_unit', 'max_unit', 'price',
        'description', 'image_url', 'available_quantity', 'warranty_len'];

}
