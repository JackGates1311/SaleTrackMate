<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $table = "recipients";
    protected $fillable = [
        'tax_code',
        'reg_id',
        'vat_id',
        'name',
        'place',
        'postal_code',
        'address',
        'phone_num',
        'fax',
        'email',
    ];
}
