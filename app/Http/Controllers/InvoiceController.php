<?php

namespace App\Http\Controllers;

use App\Enums\InvoiceAnalyticsPeriodType;
use App\Models\Company;
use App\Models\FiscalYear;
use App\Models\Invoice;
use App\Services\CompanyService;
use App\Services\GoodOrServiceService;
use App\Services\InvoiceClosureService;
use App\Services\InvoiceService;
use App\Services\RecipientService;
use App\Services\UserService;
use Carbon\Carbon;
use DOMException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class InvoiceController extends Controller
{
    private CompanyService $companyService;
    private UserService $userService;
    private InvoiceService $invoiceService;
    private RecipientService $recipientService;
    private GoodOrServiceService $goodOrServiceService;
    private InvoiceClosureService $invoiceClosureService;
    private ?Company $selected_company;

    public function __construct(CompanyService        $companyService, UserService $userService,
                                InvoiceService        $invoiceService, RecipientService $recipientService,
                                GoodOrServiceService  $goodOrServiceService,
                                InvoiceClosureService $invoiceClosureService)
    {
        $this->companyService = $companyService;
        $this->userService = $userService;
        $this->invoiceService = $invoiceService;
        $this->recipientService = $recipientService;
        $this->goodOrServiceService = $goodOrServiceService;
        $this->invoiceClosureService = $invoiceClosureService;
        $this->selected_company = null;
    }

    public function index(): Factory|View|Application|RedirectResponse
    {
        $result = $this->companyService->findByUserId($this->userService->getUserIdWeb());
        $companies = $result['companies']->toArray();
        $invoice = [];
        $invoices = [];
        $search = '';
        $selected_fiscal_year = null;

        if (request()->has('invoice')) {
            $invoice = $this->invoiceService->show(request()->query('invoice'))['invoice'];
        }
        if (request()->has('year')) {
            $selected_fiscal_year = request()->query('year');
        }
        if (request()->has('search')) {
            $search = request()->query('search');
            $company = $companies[0]['id'];

            if (request()->has('company')) {
                $company = request()->query('company');
            }

            $invoices = Invoice::where('invoice_num', 'like', '%' . $search . '%')
                ->where('company_id', $company)->get();

            if (isset($selected_fiscal_year)) {
                $invoices = $invoices->filter(function ($invoice) use ($selected_fiscal_year) {
                    $fiscal_year = FiscalYear::find($invoice->fiscal_year_id)['year'];
                    return $fiscal_year == $selected_fiscal_year;
                });
            }
        }

        if (!request()->has('company')) {
            if (!isset($companies[0]['id'])) {
                return view('invoices', ['companies' => [], 'search' => '']);
            }
            if (isset($this) && !request()->has('search')) {

                $invoices = $this->invoiceService->findByCompanyId($companies[0]['id'])['invoices'];
                if (isset($selected_fiscal_year)) {
                    $invoices = $invoices->filter(function ($invoice) use ($selected_fiscal_year) {
                        $fiscal_year = FiscalYear::find($invoice->fiscal_year_id)['year'];
                        return $fiscal_year == $selected_fiscal_year;
                    });
                }
            }
            $fiscal_years = FiscalYear::distinct()
                ->where('company_id', $companies[0]['id'])
                ->orderBy('year', 'asc')
                ->pluck('year')->toArray();
            return redirect()->route('invoices', ['company' => $companies[0]['id']])->
            with(['companies' => $companies, 'invoices' => $invoices, 'invoice' => $invoice, 'search' => $search,
                'fiscal_years' => $fiscal_years, 'selected_fiscal_year' => $selected_fiscal_year]);
        } else {
            if (!empty($this->invoiceService->findByCompanyId(request()->query('company'))['invoices']) &&
                !request()->has('search')) {
                $invoices = $this->invoiceService->findByCompanyId(request()->query('company'))['invoices'];
                if (isset($selected_fiscal_year)) {
                    $invoices = $invoices->filter(function ($invoice) use ($selected_fiscal_year) {
                        $fiscal_year = FiscalYear::find($invoice->fiscal_year_id)['year'];
                        return $fiscal_year == $selected_fiscal_year;
                    });
                }
            }
            $fiscal_years = FiscalYear::distinct()
                ->where('company_id', request()->query('company'))
                ->orderBy('year', 'asc')
                ->pluck('year')->toArray();
            return view('invoices', ['companies' => $companies, 'invoices' => $invoices, 'invoice' => $invoice,
                'search' => $search, 'fiscal_years' => $fiscal_years, 'selected_fiscal_year' => $selected_fiscal_year]);
        }
    }

    public function createView(): Factory|View|Application
    {
        $issuer = [];
        $goods_and_services = [];
        $invoice_num = '';

        if (request()->has('company')) {
            if (!empty($this->companyService->show(request()->query('company'))['company'])) {
                $issuer = $this->companyService->show(request()->query('company'))['company'];
                $issuer['recipient_list'] = $this->recipientService->getByCompanyId(request()->query('company'))
                ['recipients']->toArray();
            }
            $goods_and_services = $this->goodOrServiceService->findByCompanyId(request()->query('company'))
            ['goods_or_services']->toArray();
            $invoices = $this->invoiceService->findByCompanyId(request()->query('company'))['invoices']->toArray();
            $invoice_num = count($invoices) + 1 . '/' . Carbon::now()->year;
        }

        return view('create_invoice', ['issuer' => $issuer, 'goods_and_services' => $goods_and_services,
            'invoice_num' => $invoice_num]);
    }

    public function create(Request $request): RedirectResponse
    {
        $requestArray = $request->except('_token');

        $requestArray = $this->castInvoiceValues($requestArray);

        $result = $this->invoiceService->store($requestArray, $requestArray['company_id']);

        if ($result['success']) {
            return redirect()->route('invoices', ['company' => $result['invoice']['company_id'],
                'invoice' => $result['invoice']['id']])->with(['message' =>
                $result['invoice']['invoice_num'] . ' ' . $result['message']]);
        } else {
            return back()->withErrors(['message' => $result['message']])->withInput(request()->all());
        }
    }

    /**
     * @param array $requestArray
     * @return array
     */
    public function castInvoiceValues(array $requestArray): array
    {
        $requestArray['fiscal_year'] = (int)$requestArray['fiscal_year'];

        foreach ($requestArray['invoice_items'] as $i => $invoice_item) {
            $requestArray['invoice_items'][$i]['unit_price'] = (float)$invoice_item['unit_price'];
            $requestArray['invoice_items'][$i]['quantity'] = (float)$invoice_item['quantity'];
            $requestArray['invoice_items'][$i]['rebate'] = (float)$invoice_item['rebate'];
            $requestArray['invoice_items'][$i]['vat_percentage'] = (float)$invoice_item['vat_percentage'];
        }

        return $requestArray;
    }

    public function search(Request $request): RedirectResponse
    {
        return redirect()->route('invoices', ['company' => $request['company'],
            'invoice' => $request['invoice'], 'search' => $request['search'], 'year' => $request['year']]);
    }

    public function setYear(Request $request): RedirectResponse
    {
        return redirect()->route('invoices', ['company' => $request['company'],
            'invoice' => $request['invoice'], 'search' => $request['search'], 'year' => $request['year']]);
    }

    public function exportAsPdf()
    {
        $this->invoiceService->exportAsPdf(request()->query('invoice'));
    }

    /**
     * @throws DOMException
     */
    public function exportAsXml(): Response|Application|ResponseFactory
    {
        $invoice_xml = $this->invoiceService->exportAsXMl(request()->query('invoice'));

        $response = response($invoice_xml->content(), 200);

        $values = 'attachment; filename="invoice_' . time() . '.xml"';

        $response->header('Content-Type', 'application/xml');
        $response->header('Content-Disposition', $values);

        return $response;
    }

    public function closeInvoice(): RedirectResponse
    {
        $invoice = $this->invoiceService->show(request()->query('invoice'))['invoice'];
        $result = ['success' => false, 'message' => 'Internal Server Error 500 while closing invoice'];

        if (isset($invoice['closure'])) {
            $result = $this->invoiceClosureService->update($invoice['closure']['id'],
                $invoice['total_price'] + $invoice['total_vat']);
        }

        if ($result['success']) {
            return redirect()->route('invoices', ['company' => request()->query('company'),
                'invoice' => request()->query('invoice')])->with(['message' => $result['message']]);
        } else {
            return back()->withErrors(['message' => $result['message']]);
        }
    }

    public function analytics(): Factory|View|Application
    {
        $result = $this->invoiceService->findByCompanyId(request()->query('company'));

        if (isset($result['invoices'])) {
            $invoices = $result['invoices']->toArray();
        } else {
            $invoices = [];
        }

        $period = request()->query('period');

        if (!isset($period)) {
            $period = InvoiceAnalyticsPeriodType::DAILY->value;
        }

        $this->selected_company = $this->companyService->findSelectedCompany(request()->query('company'));

        $user_companies = $this->userService->getUserCompanies();

        $invoice_analytics = $this->invoiceService->getAnalyticsData($invoices, mb_strtoupper($period));

        return view('analytics', ['invoices' => $invoices, 'selected_company' => $this->selected_company,
            'companies' => $user_companies, 'number_of_invoices' => $invoice_analytics['number_of_invoices'],
            'average_total_price' => $invoice_analytics['average_total_price'],
            'the_most_profitable_recipients_labels' => $invoice_analytics['the_most_profitable_recipients_labels'],
            'the_most_profitable_recipients' => $invoice_analytics['the_most_profitable_recipients'],
            'the_most_loyal_recipients' => $invoice_analytics['the_most_loyal_recipients']]);
    }
}
