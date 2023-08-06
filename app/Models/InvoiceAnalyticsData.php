<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceAnalyticsData extends Model
{
    use HasFactory, HasUuids;
    public $incrementing = false;
    protected $table = "invoice_analytics_data";
    protected $fillable = [
        'number_of_invoices',
        'average_invoice_amount',
        'most_profitable_clients',
        'most_frequent_goods_or_services',
        'most_faithful_clients',
    ];
}
