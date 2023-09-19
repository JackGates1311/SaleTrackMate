<?php

namespace App\Services;

use App\Constants;
use App\Models\Invoice;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class InvoiceService
{
    /**
     * @throws ValidationException
     */

    private RecipientService $recipientService;
    private InvoiceItemService $invoiceItemService;
    private InvoiceClosureService $invoiceClosureService;
    private FiscalYearService $fiscalYearService;

    public function __construct(RecipientService      $recipientService, InvoiceItemService $invoiceItemService,
                                InvoiceClosureService $invoiceClosureService, FiscalYearService $fiscalYearService)
    {
        $this->invoiceItemService = $invoiceItemService;
        $this->recipientService = $recipientService;
        $this->invoiceClosureService = $invoiceClosureService;
        $this->fiscalYearService = $fiscalYearService;
    }

    public function store(array $data, string $issuer_company_id): array
    {
        $data['issuer_company_id'] = $issuer_company_id;

        try {
            DB::beginTransaction();
            try {
                $recipient = $this->recipientService->store($data['recipient_company']);
                $fiscal_year = $this->fiscalYearService->store($data['fiscal_year'], $issuer_company_id);

                $data['fiscal_year_id'] = $fiscal_year['fiscal_year']['id'];
                $data['recipient_company_id'] = $recipient['recipient']['id'];

                $invoice_validate_data = Validator::make($data, Invoice::$rules)->validate();

                if (count($data['invoice_items']) > 0) {

                    $invoice = new Invoice($invoice_validate_data);
                    $invoice->save();
                    $data['id'] = $invoice->getAttributes()['id'];

                    foreach ($data['invoice_items'] as $invoice_item) {
                        $invoice_item['invoice_id'] = $data['id'];
                        $this->invoiceItemService->store($invoice_item);
                    }

                    $invoice_closure = $this->invoiceClosureService->store();

                    $data['invoice_closure'] = $invoice_closure['invoice_closure'];

                    DB::commit();
                    return ['success' => true, 'message' => Constants::INVOICE_SAVE_SUCCESS, 'invoice' => $data];
                } else {
                    DB::rollBack();
                    return ['success' => false, 'message' => 'Invoice must have at least one invoice item'];
                }
            } catch (Exception $e) {
                DB::rollBack();
                return ['success' => false, 'message' => Constants::INVOICE_SAVE_FAIL . ': ' . $e->getMessage()];
            }
        } catch (Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => Constants::INVOICE_SAVE_FAIL . ': ' . $e->getMessage()];
        }
    }

    public function index(): array
    {
        return ['invoices' => Invoice::with('fiscalYear', 'recipient', 'issuer', 'invoiceItems')->get()->toArray()];
    }

    public function show($id): array
    {
        $invoice = Invoice::with('fiscalYear', 'recipient', 'issuer', 'invoiceItems')->find($id);

        if (!$invoice) {
            return ['success' => false, 'message' => Constants::INVOICE_NOT_FOUND . ' ' . $id];
        }
        return ['success' => true, 'message' => 'OK', 'invoice' => $invoice->toArray()];
    }

    /**
     * @throws ValidationException
     */
    public function update(array $data, $id): array
    {
        $validated_data = Validator::make($data, Invoice::$rules)->validate();

        $invoice = Invoice::find($id);

        if (!$invoice) {
            return ['success' => false, 'message' => Constants::INVOICE_NOT_FOUND];
        }

        try {
            $invoice->update($validated_data);
            return ['success' => true, 'message' => Constants::INVOICE_UPDATE_SUCCESS,
                'invoice' => $invoice];
        } catch (Exception $e) {
            return ['success' => false, 'message' => Constants::INVOICE_UPDATE_FAIL . ': ' . $e->getMessage()];
        }
    }
}
