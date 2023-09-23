<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $validated_data)
 * @method static find($id)
 */
class TaxRate extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $table = "tax_rates";

    protected $fillable = [
        'percentage_value',
        'from_date'
    ];

    public static array $rules = [
        'percentage_value' => 'required|numeric|between:0,1',
        'from_date' => 'required|date',
    ];

}
