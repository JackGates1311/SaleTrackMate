<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $validated_data)
 * @method static find($id)
 */
class PriceDiscount extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $table = "price_discounts";
    protected $fillable = [
        'percentage',
        'from_date',
        'due_date',
    ];

    public static array $rules = [
        'percentage' => 'required|numeric|between:0,1',
        'from_date' => 'required|date_format:Y-m-d H:i:s',
        'due_date' => 'required|date_format:Y-m-d H:i:s',
    ];
}
