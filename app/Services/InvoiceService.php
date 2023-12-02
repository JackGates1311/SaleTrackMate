<?php

namespace App\Services;

use App\Constants;
use App\Models\Company;
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
    private InvoiceItemService $invoiceItemService;
    private CompanyService $companyService;
    private InvoiceClosureService $invoiceClosureService;
    private FiscalYearService $fiscalYearService;
    private InvoiceIssuerService $invoiceIssuerService;
    private InvoiceRecipientService $invoiceRecipientService;
    private BankAccountService $bankAccountService;

    public function __construct(InvoiceItemService      $invoiceItemService, CompanyService $companyService,
                                InvoiceClosureService   $invoiceClosureService, FiscalYearService $fiscalYearService,
                                InvoiceIssuerService    $invoiceIssuerService,
                                InvoiceRecipientService $invoiceRecipientService,
                                BankAccountService      $bankAccountService)
    {
        $this->invoiceItemService = $invoiceItemService;
        $this->companyService = $companyService;
        $this->invoiceClosureService = $invoiceClosureService;
        $this->fiscalYearService = $fiscalYearService;
        $this->invoiceIssuerService = $invoiceIssuerService;
        $this->invoiceRecipientService = $invoiceRecipientService;
        $this->bankAccountService = $bankAccountService;
    }

    public function store(array $data, string $company_id): array
    {
        $calculated_invoice_values = $this->calculateInvoiceValues($data);

        $data['company_id'] = $company_id;

        $data['total_base_amount'] = $calculated_invoice_values['total_base_amount'];
        $data['total_price'] = $calculated_invoice_values['total_price'];
        $data['total_vat'] = $calculated_invoice_values['total_vat'];
        $data['total_rebate'] = $calculated_invoice_values['total_rebate'];

        try {
            DB::beginTransaction();
            try {

                //TODO add check if bank accounts belongs to recipient and issuer companies ...
                //TODO also check for user auth there

                $issuer_data = $this->companyService->show($company_id)['company'];
                $issuer_bank_account = $this->bankAccountService->show($data['issuer_bank_account'])['bank_account']->
                toArray();
                $issuer_data['bank_name'] = $issuer_bank_account['name'];
                $issuer_data['iban'] = $issuer_bank_account['iban'];

                $issuer = $this->invoiceIssuerService->store($issuer_data);
                $recipient = $this->invoiceRecipientService->store($data['recipient']);
                $fiscal_year = $this->fiscalYearService->store($data['fiscal_year'], $company_id);

                $data['currency'] = strtoupper($data['currency']);
                $data['fiscal_year_id'] = $fiscal_year['fiscal_year']['id'];
                $data['recipient_company_id'] = $recipient['invoice_recipient']['id'];
                $data['issuer_company_id'] = $issuer['invoice_issuer']['id'];

                $invoice_validate_data = Validator::make($data, Invoice::$rules)->validate();

                if (count($data['invoice_items']) > 0) {

                    $invoice = new Invoice($invoice_validate_data);
                    $invoice->save();
                    $data['id'] = $invoice->getAttributes()['id'];
                    foreach ($data['invoice_items'] as $invoice_item) {
                        $invoice_item['invoice_id'] = $data['id'];

                        $calculated_invoice_item_values = $this->calculateInvoiceItemValues($invoice_item);

                        $invoice_item['base_amount'] = $calculated_invoice_item_values['base_amount'];
                        $invoice_item['vat_price'] = $calculated_invoice_item_values['vat_price'];
                        $invoice_item['total_price'] = $calculated_invoice_item_values['total_price'];

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

    public function calculateInvoiceValues(array $data): array
    {
        $total_base_amount = collect($data['invoice_items'])->sum(function ($item) {
            return $item['unit_price'] * $item['quantity'];
        });

        $total_price = collect($data['invoice_items'])->sum(function ($item) {
            return $item['unit_price'] * $item['quantity'] - $item['rebate'];
        });

        $total_vat = collect($data['invoice_items'])->sum(function ($item) {
            return ($item['unit_price'] * $item['quantity'] - $item['rebate']) * ($item['vat_percentage'] / 100);
        });

        $total_rebate = collect($data['invoice_items'])->sum('rebate');

        return ['total_base_amount' => $total_base_amount, 'total_price' => $total_price,
            'total_vat' => $total_vat, 'total_rebate' => $total_rebate];
    }

    public function calculateInvoiceItemValues(array $data): array
    {
        $base_amount = $data['unit_price'] * $data['quantity'];
        $vat_price = ($data['unit_price'] * $data['quantity'] - $data['rebate']) * ($data['vat_percentage'] / 100);
        $total_price = $base_amount + $vat_price;

        return ['base_amount' => $base_amount, 'vat_price' => $vat_price, 'total_price' => $total_price];
    }

    public function findByCompanyId($id): array
    {
        $company = (new Company)->find($id);

        if (!$company) {
            return ['success' => false, 'message' => Constants::COMPANY_NOT_FOUND . ': ' . $id];
        } else {
            $invoices = $company->invoices;
        }

        if (!$invoices) {
            return ['success' => false, 'message' => Constants::INVOICE_NOT_FOUND . ': ' . $id];
        }

        return ['success' => true, 'invoices' => $invoices];
    }
}
