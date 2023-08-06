<?php

namespace App\Models;

use App\Enums\InvoiceStatus;
use App\Enums\InvoiceType;
use App\Enums\PaymentMethod;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $table = "invoices";
    protected $fillable = [
        'invoice_num',
        'invoice_date',
        'invoice_location',
        'due_date',
        'due_location',
        'delivery_date',
        'delivery_location',
        'payment_method',
        'payment_deadline',
        'fiscal_receipt_num',
        'total_base_amount',
        'total_price',
        'total_vat',
        'total_rebate',
        'status',
        'type',
    ];

    protected InvoiceStatus $status;
    protected InvoiceType $type;
    protected PaymentMethod $payment_method;

    public function issuerCompany(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'issuer_company_id', 'id');
    }

    public function recipientCompany(): BelongsTo
    {
        return $this->belongsTo(Recipient::class, 'recipient_company_id', 'id');
    }

    public function articles(): HasMany
    {
        return $this->HasMany(InvoiceItems::class, 'invoice_id', 'id');
    }

}
