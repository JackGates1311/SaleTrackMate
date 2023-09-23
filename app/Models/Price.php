<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $validated_data)
 * @method static find($id)
 */
class Price extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $table = "prices";

    protected $fillable = [
        'amount',
        'expiration_date',
    ];

    public static array $rules = [
        'amount' => 'required|numeric',
        'expiration_date' => 'required|date',
    ];

}
