<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $table = "prices";

    protected $fillable = [
        'amount',
        'expiration_date',
    ];
}
