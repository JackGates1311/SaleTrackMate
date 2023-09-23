<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $validated_data)
 * @method static find($id)
 */
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

    public static array $rules = [
        'abbreviation' => 'required|string|max:255',
        'description' => 'required|string|max:255',
        'full_name' => 'required|string|max:255',
    ];

}
