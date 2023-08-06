<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceDiscount extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $table = "price_discounts";
    protected $fillable = [
        'percentage',
        'from_date',
        'due_date',
    ];
}
