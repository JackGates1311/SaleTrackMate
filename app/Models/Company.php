<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static find($id)
 * @method where(string $string, $companyId)
 * @method static create($validated_data)
 */
class Company extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $table = "companies";
    protected $fillable = [
        'company_id',
        'tax_code',
        'reg_id',
        'vat_id',
        'name',
        'category',
        'country',
        'place',
        'postal_code',
        'address',
        'phone_num',
        'fax',
        'email',
        'url',
        'logo_url',
        'user_id'
    ];

    public function articles(): HasMany
    {
        return $this->hasMany(GoodOrService::class);
    }

    /**
     * @noinspection PhpUnused
     */

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'issuer_company_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @noinspection PhpUnused
     */
    public function bankAccounts(): HasMany
    {
        return $this->hasMany(BankAccount::class);
    }

    /**
     * @noinspection PhpUnused
     */
    public function fiscalYears(): HasMany
    {
        return $this->hasMany(FiscalYear::class);
    }

    public static array $rules = [
        'company_id' => 'required|string|max:255',
        'tax_code' => 'required|string|max:255',
        'reg_id' => 'nullable|string|max:255',
        'vat_id' => 'nullable|string|max:255',
        'name' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'country' => 'required|string|min:2|max:2',
        'place' => 'required|string|max:255',
        'postal_code' => 'required|string|max:10',
        'address' => 'required|string|max:255',
        'phone_num' => 'nullable|string|max:255',
        'fax' => 'nullable|string|max:255',
        'email' => 'nullable|string|email|max:255',
        'url' => 'nullable|string|url|max:255',
        'logo_url' => 'nullable|string|url|max:255',
        'user_id' => 'required|uuid'
    ];
}
