<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticate;


/**
 * @mixin Builder
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $first_name
 * @property string|null $middle_name
 * @property string $last_name
 * @property string $country
 * @property string $city
 * @property string $address
 * @property string $postal_code
 * @property string $phone
 * @property string|null $fax
 * @property bool $is_active
 * @property array $companies
 * @property string $id
 */
class User extends Authenticate
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

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

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }

    public static array $rules = [
        'first_name' => 'required',
        'middle_name' => 'nullable',
        'last_name' => 'required',
        'username' => 'required|min:5',
        'email' => 'required|email',
        'password' => 'required|min:8',
        'country' => 'required|min:2|max:2',
        'city' => 'required',
        'postal_code' => 'required',
        'address' => 'required',
        'phone' => 'required',
        'fax' => 'nullable',
    ];
}
