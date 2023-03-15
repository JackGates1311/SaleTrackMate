<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static find($id)
 */
class Invoice extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $table = "invoices";
    protected $fillable = ['issuer_company_id', 'recipient_company_id', 'invoice_num', 'invoice_date',
        'invoice_location', 'due_date', 'due_location', 'delivery_date', 'delivery_location', 'payment_method',
        'payment_deadline', 'fiscal_receipt_num', 'articles_id'];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function recipientCompany(): BelongsTo
    {
        return $this->belongsTo(InvoiceRecipient::class);
    }

    public function issuerCompany(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

}
