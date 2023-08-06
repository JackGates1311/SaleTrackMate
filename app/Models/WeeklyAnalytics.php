<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyAnalytics extends Model
{
    use HasFactory, HasUuids;
    public $incrementing = false;
    protected $table = "weekly_analytics";
    protected $fillable = [
        'week_of_year'
    ];
}
