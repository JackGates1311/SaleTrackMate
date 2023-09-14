<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $validated_data)
 * @method static find($id)
 */
class BankAccount extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $table = "bank_accounts";
    protected $fillable = [
        'bank_identifier',
        'name',
        'iban',
        'company_id'
    ];

    private function company(): BelongsTo // fix not use
    {
        return $this->belongsTo(Company::class);
    }

    public static array $rules = [
        'bank_identifier' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'iban' => 'required|string|max:255',
        'company_id' => 'required|uuid'
    ];
}
