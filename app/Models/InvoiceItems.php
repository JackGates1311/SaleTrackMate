<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItems extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $table = "invoice_articles";
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
    ];
}
