<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitOfMeasure extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $table = "unit_of_measures";
    protected $fillable = [
        'abbreviation',
        'description',
        'full_name',
    ];
}
