<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyAnalytics extends Model
{
    use HasFactory, HasUuids;
    public $incrementing = false;
    protected $table = "daily_analytics";
    protected $fillable = [
        'date'
    ];
}
