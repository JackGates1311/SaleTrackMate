<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static find($id)
 * @method static create(array $validated_data)
 */
class GoodOrServiceDetails extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $table = "goods_or_services_details";
    protected $fillable = [
        'url',
        'category',
        'supplier',
        'country_origin',
        'country_origin_code',
        'weight',
        'dimensions',
        'color',
    ];

    public static array $rules = [
        'url' => 'nullable|url',
        'category' => 'nullable|string|max:255',
        'supplier' => 'nullable|string|max:255',
        'country_origin' => 'nullable|string|max:255',
        'country_origin_code' => 'nullable|string|max:255',
        'weight' => 'nullable|numeric',
        'dimensions' => 'nullable|string|max:255',
        'color' => 'nullable|string|max:255',
    ];

}
