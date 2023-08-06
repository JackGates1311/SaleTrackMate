<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxRate extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $table = "tax_rates";

    protected $fillable = [
        'percentage_value',
        'from_date'
    ];
}
