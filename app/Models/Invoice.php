<?php

namespace App\Models;

use App\Enums\InvoiceStatus;
use App\Enums\InvoiceType;
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
        'company_id',
        'issuer_company_id',
        'recipient_company_id',
        'fiscal_year_id'
    ];

    protected InvoiceStatus $status;
    protected InvoiceType $type;

    /**
     * @noinspection PhpUnused
     */
    public function issuer(): belongsTo //TODO figure out why hasOne relation returns null?!
    {
        return $this->belongsTo(InvoiceIssuer::class, 'issuer_company_id', 'id');
    }

    public function recipient(): belongsTo
    {
        return $this->belongsTo(InvoiceRecipient::class, 'recipient_company_id', 'id');
    }

    /**
     * @noinspection PhpUnused
     */
    public function invoiceItems(): HasMany
    {
        return $this->HasMany(InvoiceItem::class, 'invoice_id', 'id');
    }

    /**
     * @noinspection PhpUnused
     */
    public function fiscalYear(): BelongsTo
    {
        return $this->belongsTo(FiscalYear::class, 'fiscal_year_id', 'id');
    }

    public static array $rules = [
        'invoice_num' => 'required|string|max:255',
        'invoice_date' => 'required|date',
        'invoice_location' => 'required|string|max:255',
        'due_date' => 'required|date',
        'due_location' => 'required|string|max:255',
        'delivery_date' => 'required|date',
        'delivery_location' => 'required|string|max:255',
        'payment_method' => 'required|in:ADVANCE_PAYMENT,BANK_TRANSFER,CASH_PAYMENT',
        'payment_deadline' => 'required|date',
        'fiscal_receipt_num' => 'required|string|max:255',
        'total_base_amount' => 'required|numeric',
        'total_price' => 'required|numeric',
        'total_vat' => 'required|numeric',
        'total_rebate' => 'required|numeric',
        'status' => 'required|in:STAGING,SENT,CANCELLED',
        'type' => 'required|in:INVOICE,PROFORMA',
        'company_id' => 'required|uuid',
        'issuer_company_id' => 'required|uuid',
        'recipient_company_id' => 'required|uuid',
        'fiscal_year_id' => 'required|uuid',
    ];
}
