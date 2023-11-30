<?php

namespace App\Models;

use App\Enums\GoodsOrServicesType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static find($id)
 * @method static create(array $validated_data)
 */
class GoodOrService extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $table = "goods_or_services";
    protected $fillable = [
        'serial_num',
        'name',
        'description',
        'image_url',
        'warranty_len',
        'type',
        'company_id',
        'tax_category_id',
        'unit_of_measure_id',
        'good_or_service_details_id'
    ];

    protected GoodsOrServicesType $type;

    public static array $rules = [
        'serial_num' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'image_url' => 'nullable|url',
        'warranty_len' => 'nullable|integer|min:0',
        'type' => 'required|in:GOOD,SERVICE',
        'company_id' => 'required|string|max:255',
        'tax_category_id' => 'nullable|uuid',
        'unit_of_measure_id' => 'nullable|uuid',
        'good_or_service_details_id' => 'nullable|uuid',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function goodOrServiceDetails(): HasOne
    {
        return $this->hasOne(GoodOrServiceDetails::class, 'id', 'good_or_service_details_id');
    }

    public function priceDiscounts(): HasMany
    {
        return $this->hasMany(PriceDiscount::class, '', 'id');
    }

    public function unitOfMeasure(): HasOne
    {
        return $this->hasOne(UnitOfMeasure::class, 'id', 'unit_of_measure_id');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(Price::class, 'good_or_service_id', 'id')->
        orderBy('expiration_date');
    }

    public function taxCategory(): HasOne
    {
        return $this->hasOne(TaxCategory::class, 'id', 'tax_category_id');
    }
}
