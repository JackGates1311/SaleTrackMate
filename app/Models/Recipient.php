<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $validated_data)
 */
class Recipient extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $table = "recipients";
    protected $fillable = [
        'tax_code',
        'reg_id',
        'vat_id',
        'name',
        'place',
        'postal_code',
        'address',
        'phone_num',
        'fax',
        'email',
        'company_id',
    ];

    /**
     * @noinspection PhpUnused
     */
    public function bankAccounts(): HasMany
    {
        return $this->hasMany(BankAccount::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }


    public static array $rules = [
        'tax_code' => 'required|string|max:255',
        'reg_id' => 'nullable|string|max:255',
        'vat_id' => 'nullable|string|max:255',
        'name' => 'required|string|max:255',
        'place' => 'required|string|max:255',
        'postal_code' => 'required|string|max:10',
        'address' => 'required|string|max:255',
        'phone_num' => 'nullable|string|max:255',
        'fax' => 'nullable|string|max:255',
        'email' => 'nullable|string|email|max:255',
        'company_id' => 'uuid|required',
    ];
}
