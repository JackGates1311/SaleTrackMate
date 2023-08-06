<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyAnalytics extends Model
{
    use HasFactory, HasUuids;
    public $incrementing = false;
    protected $table = "monthly_analytics";
    protected $fillable = [
        'month'
    ];
}
