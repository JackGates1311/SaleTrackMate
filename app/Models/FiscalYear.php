<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiscalYear extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $table = "fiscal_years";

    protected $fillable = [
        'year',
        'is_closed',
    ];

}
