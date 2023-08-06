<?php

namespace App\Models;

use App\Enums\GoodsOrServicesType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static find($id)
 */
class GoodsOrServices extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $table = "goods_or_services";
    protected $fillable = [
        'id',
        'serial_num',
        'name',
        'description',
        'image_url',
        'available_quantity',
        'warranty_len',
        'type',
    ];

    protected GoodsOrServicesType $type;

    public function articleDetails(): BelongsTo
    {
        return $this->belongsTo(GoodsOrServicesDetails::class, 'id', 'article_id');
    }
}
