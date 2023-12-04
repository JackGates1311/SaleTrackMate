<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $validated_data)
 * @method static find($id)
 */
class InvoiceClosure extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $table = "invoice_closures";
    protected $fillable = [
        'closure_date',
        'closure_amount',
        'invoice_id'
    ];

    public static array $rules = [
        'closure_date' => 'nullable|date',
        'closure_amount' => 'required|numeric|min:0',
        'invoice_id' => 'required|uuid',
    ];

}
