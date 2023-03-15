<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceRecipient extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $table = "invoice_recipients";
    protected $fillable = ['invoice_id', 'recipient_id', 'tax_code', 'reg_id', 'vat_id', 'name', 'place',
        'postal_code', 'address', 'iban', 'phone_num', 'fax', 'email'];
}
