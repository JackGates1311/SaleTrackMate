<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $validated_data)
 */
class FiscalYear extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $table = "fiscal_years";

    protected $fillable = [
        'year',
        'is_closed',
        'company_id'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public static array $rules = [
        'year' => 'required|integer|min:1900|max:9999',
        'is_closed' => 'required|boolean',
        'company_id' => 'required|uuid',
    ];
}
