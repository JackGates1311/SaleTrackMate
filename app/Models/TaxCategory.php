<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $validated_data)
 * @method static find($id)
 */
class TaxCategory extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $table = "tax_categories";

    protected $fillable = [
        'name',
    ];

    public function taxRates(): HasMany
    {
        return $this->HasMany(TaxRate::class, 'tax_category_id', 'id')->
        orderBy('from_date');
    }

    public static array $rules = [
        'name' => 'required|string|max:255',
    ];
}
