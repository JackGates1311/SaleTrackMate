<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $validated_data)
 */
class InvoiceItem extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $table = "invoice_items";
    protected $fillable = [
        'name',
        'unit',
        'unit_price',
        'quantity',
        'base_amount',
        'rebate',
        'vat_price',
        'vat_percentage',
        'total_price',
        'image_url',
        'invoice_id'
    ];

    public static array $rules = [
        'name' => 'required|string|max:255',
        'unit' => 'required|string|max:255',
        'unit_price' => 'required|numeric|min:0',
        'quantity' => 'required|numeric|min:0',
        'base_amount' => 'required|numeric|min:0',
        'rebate' => 'required|numeric|min:0',
        'vat_price' => 'required|numeric|min:0',
        'vat_percentage' => 'required|numeric|min:0|max:100',
        'total_price' => 'required|numeric|min:0',
        'image_url' => 'nullable|url|max:255',
        'invoice_id' => 'required|uuid',
    ];
}
