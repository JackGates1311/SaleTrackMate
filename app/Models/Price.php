<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static create(array $validated_data)
 * @method static find($id)
 * @method static where(string $string, string $good_or_service_id)
 */
class Price extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $table = "prices";

    protected $fillable = [
        'amount',
        'expiration_date',
        'good_or_service_id'
    ];

    public static array $rules = [
        'amount' => 'required|numeric',
        'expiration_date' => 'required|date',
        'good_or_service_id' => 'required|uuid',
    ];

    public function goodOrService(): HasOne
    {
        return $this->hasOne(GoodOrService::class, 'id', 'good_or_service_id');
    }
}
