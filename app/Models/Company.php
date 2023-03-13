<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static find($id)
 */
class Company extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $table = "companies";
    protected $fillable = ['company_id', 'tax_code', 'reg_id', 'vat_id', 'name', 'category', 'country', 'place',
        'postal_code', 'address', 'iban', 'bank_name', 'phone_num', 'fax', 'email', 'url', 'logo_url'];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
