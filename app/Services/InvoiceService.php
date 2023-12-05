<?php

namespace App\Services;

use App\Constants;
use App\Enums\InvoiceAnalyticsPeriodType;
use App\Helper\GenerateData;
use App\Models\Company;
use App\Models\Invoice;
use Carbon\Carbon;
use DOMException;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
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

                    $invoice_closure = $this->invoiceClosureService->store($invoice->getAttributes()['id']);

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
        return ['invoices' => Invoice::with('fiscalYear', 'recipient', 'issuer', 'invoiceItems', 'closure')->
        get()->toArray()];
    }

    public function show($id): array
    {
        $invoice = Invoice::with('fiscalYear', 'recipient', 'issuer', 'invoiceItems', 'closure')->find($id);

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

        foreach ($invoices as $invoice) {
            $invoice->load('fiscalYear');
            $invoice->load('recipient');
            $invoice->load('issuer');
            $invoice->load('invoiceItems');
            $invoice->load('closure');
        }

        return ['success' => true, 'invoices' => $invoices];
    }

    public function exportAsPdf($id): void
    {
        $result = $this->show($id);
        if ($result['success']) {
            (new GenerateData)->generatePdf($result['invoice']);
        }
    }

    /**
     * @throws DOMException
     */
    public function exportAsXml($id): Response|Application|ResponseFactory
    {
        $headers = [
            'Content-type' => 'application/xml'
        ];

        $result = $this->show($id);

        if ($result['success']) {
            $invoice = $this->generateInvoiceXmlData($result['invoice']);

            if ($invoice) {
                return response((new GenerateData)->generateXml($invoice), 200, $headers);
            }
        }

        return response(json_encode('Cannot generate XML file - ' . Constants::INVOICE_NOT_FOUND . ': ' . $id),
            404);
    }

    public function generateInvoiceXmlData(array $invoice): array
    {
        $invoice['invoice_type_code'] = 300;
        $invoice['description_code'] = 35;
        $invoice['scheme_id'] = "9948";
        $invoice['recipient']['budget_user_number'] = "JBKJS:12345";
        $invoice['recipient']['company_id'] = '';
        $invoice['recipient']['email'] = '';
        $invoice['payment_code'] = 30;
        $invoice['payment_mod'] = 97;
        $invoice['payment_id'] = $invoice['invoice_num'];
        $invoice['tax_scheme'] = "VAT";
        $invoice['tax_exemption_reason_code'] = "PDV-RS-11-1-4";
        $invoice['allowance_total_amount'] = 0;
        $invoice['prepaid_amount'] = 0;

        foreach ($invoice['invoice_items'] as $i => $invoice_item) {
            if ($invoice['total_vat'] != 0.0) {
                $invoice['invoice_items'][$i]['tax_id'] = "S";
            } else {
                $invoice['invoice_items'][$i]['tax_id'] = "O";
            }
        }

        return $invoice;
    }

    public function getAnalyticsData(array $invoices, string $period): array
    {
        $number_of_invoices = [];
        $average_total_price = [];
        $the_most_profitable_recipients = [];
        $the_most_profitable_recipients_labels = [];
        $the_most_loyal_recipients = [];

        if ($period == InvoiceAnalyticsPeriodType::YEARLY->value) {
            $year = Carbon::now()->year;
            for ($i = 0; $i < 12; $i++) {
                $count = 0;
                $total_price_amount = 0;

                foreach ($invoices as $invoice) {
                    if (Carbon::parse($invoice['created_at'])->year == $year &&
                        Carbon::parse($invoice['created_at'])->month == $i + 1) {
                        $count++;
                        $total_price_amount += floatval($invoice['total_price'] + $invoice['total_vat']);
                        $the_most_profitable_recipients_labels[$invoice['recipient']['vat_id']] =
                            $invoice['recipient']['name'];
                    }
                }

                $number_of_invoices[$i] = $count;
                $average_total_price[$i] = $count > 0 ? $total_price_amount / $count : 0;
            }

            $the_most_profitable_recipients_labels = array_unique($the_most_profitable_recipients_labels);

            foreach (array_keys($the_most_profitable_recipients_labels) as $recipient_vat_id) {
                $the_most_profitable_recipients[$recipient_vat_id] = 0;
                $the_most_loyal_recipients[$recipient_vat_id] = 0;
                for ($k = 0; $k < 12; $k++) {
                    $loyalty_count = 0;
                    foreach ($invoices as $invoice) {
                        if (Carbon::parse($invoice['created_at'])->year == $year &&
                            Carbon::parse($invoice['created_at'])->month == $k + 1) {

                            if ($invoice['recipient']['vat_id'] == $recipient_vat_id) {
                                $loyalty_count++;
                                $the_most_profitable_recipients[$recipient_vat_id] +=
                                    floatval($invoice['total_price'] + $invoice['total_vat']);
                                $the_most_loyal_recipients[$recipient_vat_id] = $loyalty_count;
                            }
                        }
                    }
                }
            }
        }

        if ($period == InvoiceAnalyticsPeriodType::MONTHLY->value) {
            $month = Carbon::now()->month;
            $days_of_month = Carbon::now()->daysInMonth;

            for ($i = 0; $i < $days_of_month; $i++) {
                $count = 0;
                $total_price_amount = 0;

                foreach ($invoices as $invoice) {
                    if (Carbon::parse($invoice['created_at'])->month == $month &&
                        Carbon::parse($invoice['created_at'])->day == $i + 1) {
                        $count++;
                        $total_price_amount += floatval($invoice['total_price'] + $invoice['total_vat']);
                        $the_most_profitable_recipients_labels[$invoice['recipient']['vat_id']] =
                            $invoice['recipient']['name'];
                    }
                }
                $number_of_invoices[$i] = $count;
                $average_total_price[$i] = $count > 0 ? $total_price_amount / $count : 0;
            }

            $the_most_profitable_recipients_labels = array_unique($the_most_profitable_recipients_labels);

            foreach (array_keys($the_most_profitable_recipients_labels) as $recipient_vat_id) {
                $the_most_profitable_recipients[$recipient_vat_id] = 0;
                $the_most_loyal_recipients[$recipient_vat_id] = 0;
                for ($k = 0; $k < $days_of_month; $k++) {
                    $loyalty_count = 0;
                    foreach ($invoices as $invoice) {
                        if (Carbon::parse($invoice['created_at'])->month == $month &&
                            Carbon::parse($invoice['created_at'])->day == $k + 1) {
                            if ($invoice['recipient']['vat_id'] == $recipient_vat_id) {
                                $loyalty_count++;
                                $the_most_profitable_recipients[$recipient_vat_id] +=
                                    floatval($invoice['total_price'] + $invoice['total_vat']);
                                $the_most_loyal_recipients[$recipient_vat_id] = $loyalty_count;
                            }
                        }
                    }
                }
            }
        }

        if ($period == InvoiceAnalyticsPeriodType::WEEKLY->value) {
            $week_of_year = Carbon::now()->isoWeek();
            for ($i = 0; $i < 7; $i++) {
                $count = 0;
                $total_price_amount = 0;

                foreach ($invoices as $invoice) {
                    if (Carbon::parse($invoice['created_at'])->week == $week_of_year &&
                        Carbon::parse($invoice['created_at'])->dayOfWeek == $i + 1) {
                        $count++;
                        $total_price_amount += floatval($invoice['total_price'] + $invoice['total_vat']);
                        $the_most_profitable_recipients_labels[$invoice['recipient']['vat_id']] =
                            $invoice['recipient']['name'];
                    }
                }
                $number_of_invoices[$i] = $count;
                $average_total_price[$i] = $count > 0 ? $total_price_amount / $count : 0;
            }

            $the_most_profitable_recipients_labels = array_unique($the_most_profitable_recipients_labels);

            foreach (array_keys($the_most_profitable_recipients_labels) as $recipient_vat_id) {
                $the_most_profitable_recipients[$recipient_vat_id] = 0;
                $the_most_loyal_recipients[$recipient_vat_id] = 0;
                for ($k = 0; $k < 7; $k++) {
                    $loyalty_count = 0;
                    foreach ($invoices as $invoice) {
                        if (Carbon::parse($invoice['created_at'])->week == $week_of_year &&
                            Carbon::parse($invoice['created_at'])->dayOfWeek == $k + 1) {

                            if ($invoice['recipient']['vat_id'] == $recipient_vat_id) {
                                $loyalty_count++;
                                $the_most_profitable_recipients[$recipient_vat_id] +=
                                    floatval($invoice['total_price'] + $invoice['total_vat']);
                                $the_most_loyal_recipients[$recipient_vat_id] = $loyalty_count;
                            }
                        }
                    }
                }
            }
        }

        if ($period == InvoiceAnalyticsPeriodType::DAILY->value) {
            $day = Carbon::now()->day;
            for ($i = 0; $i < 24; $i++) {
                $count = 0;
                $total_price_amount = 0;

                foreach ($invoices as $invoice) {
                    if (Carbon::parse($invoice['created_at'])->day == $day &&
                        Carbon::parse($invoice['created_at'])->hour == $i) {
                        $count++;
                        $total_price_amount += floatval($invoice['total_price'] + $invoice['total_vat']);
                        $the_most_profitable_recipients_labels[$invoice['recipient']['vat_id']] =
                            $invoice['recipient']['name'];
                    }
                }
                $number_of_invoices[$i] = $count;
                $average_total_price[$i] = $count > 0 ? $total_price_amount / $count : 0;
            }

            $the_most_profitable_recipients_labels = array_unique($the_most_profitable_recipients_labels);

            foreach (array_keys($the_most_profitable_recipients_labels) as $recipient_vat_id) {
                $the_most_profitable_recipients[$recipient_vat_id] = 0;
                $the_most_loyal_recipients[$recipient_vat_id] = 0;
                for ($k = 0; $k < 24; $k++) {
                    $loyalty_count = 0;
                    foreach ($invoices as $invoice) {
                        if (Carbon::parse($invoice['created_at'])->day == $day &&
                            Carbon::parse($invoice['created_at'])->hour == $k) {

                            if ($invoice['recipient']['vat_id'] == $recipient_vat_id) {
                                $loyalty_count++;
                                $the_most_profitable_recipients[$recipient_vat_id] +=
                                    floatval($invoice['total_price'] + $invoice['total_vat']);
                                $the_most_loyal_recipients[$recipient_vat_id] = $loyalty_count;
                            }
                        }
                    }
                }
            }
        }

        return ['number_of_invoices' => $number_of_invoices, 'average_total_price' => $average_total_price,
            'the_most_profitable_recipients_labels' => $the_most_profitable_recipients_labels,
            'the_most_profitable_recipients' => $the_most_profitable_recipients,
            'the_most_loyal_recipients' => $the_most_loyal_recipients];
    }
}
