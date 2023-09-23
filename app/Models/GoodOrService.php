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
        'id',
        'serial_num',
        'name',
        'description',
        'image_url',
        'available_quantity',
        'warranty_len',
        'type',
        'company_id',
        'price_id',
        'tax_category_id',
        'good_or_service_details_id'
    ];

    protected GoodsOrServicesType $type;

    public static array $rules = [
        'serial_num' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'description' => 'string',
        'image_url' => 'nullable|url',
        'available_quantity' => 'nullable|numeric|min:0',
        'warranty_len' => 'nullable|integer|min:0',
        'type' => 'required|in:GOOD,SERVICE',
        'company_id' => 'required|string|max:255',
        'price_id' => 'required|uuid',
        'tax_category_id' => 'required|uuid',
        'good_or_service_details_id' => 'nullable|uuid',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function goodOrServiceDetails(): HasOne
    {
        return $this->hasOne(GoodOrServiceDetails::class, 'good_or_service_details_id', 'id');
    }

    public function priceDiscounts(): HasMany
    {
        return $this->hasMany(PriceDiscount::class, '', 'id');
    }

    public function unitOfMeasure(): HasOne
    {
        return $this->hasOne(UnitOfMeasure::class, 'unit_of_measure_id', 'id');
    }

    public function price(): HasOne
    {
        return $this->hasOne(Price::class, 'price_id', 'id');
    }

    public function taxCategory(): HasOne
    {
        return $this->hasOne(TaxCategory::class, 'tax_category_id', 'id');
    }
}
