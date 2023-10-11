<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $validated_data)
 */
class InvoiceIssuer extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $table = "invoice_issuers";
    protected $fillable = [
        'company_id',
        'tax_code',
        'reg_id',
        'vat_id',
        'name',
        'country',
        'place',
        'postal_code',
        'address',
        'phone_num',
        'fax',
        'email',
        'url',
        'bank_name',
        'iban',
    ];

    public static array $rules = [
        'company_id' => 'required|string|max:255',
        'tax_code' => 'required|string|max:255',
        'reg_id' => 'nullable|string|max:255',
        'vat_id' => 'nullable|string|max:255',
        'name' => 'required|string|max:255',
        'country' => 'required|string|min:2|max:2',
        'place' => 'required|string|max:255',
        'postal_code' => 'required|string|max:10',
        'address' => 'required|string|max:255',
        'phone_num' => 'nullable|string|max:255',
        'fax' => 'nullable|string|max:255',
        'email' => 'nullable|string|email|max:255',
        'url' => 'nullable|string|url|max:255',
        'bank_name' => 'required|string|max:255',
        'iban' => 'required|string|max:255',
    ];
}
