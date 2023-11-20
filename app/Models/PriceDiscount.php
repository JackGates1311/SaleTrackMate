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
        'good_or_service_id',
    ];

    public static array $rules = [
        'percentage' => 'required|numeric|between:0,100',
        'from_date' => 'required|date',
        'due_date' => 'required|date',
        'good_or_service_id' => 'required|uuid',
    ];
}
