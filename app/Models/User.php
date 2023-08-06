<?php

namespace App\Models;

use App\Enums\AccountType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $table = "users";
    protected $fillable = [
        'username',
        'email',
        'password',
        'first_name',
        'middle_name',
        'last_name',
        'country',
        'city',
        'address',
        'postal_code',
        'phone',
        'fax',
        'is_active',
        'account_type',
    ];

    protected AccountType $account_type;
}
