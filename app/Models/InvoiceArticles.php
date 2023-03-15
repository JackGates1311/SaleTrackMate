<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceArticles extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $table = "invoice_articles";
    protected $fillable = ['invoice_id', 'article_id', 'name', 'unit', 'quantity', 'price', 'rebate', 'vat',
        'price_with_vat', 'image_url'];

}
