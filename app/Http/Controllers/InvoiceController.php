<?php

namespace App\Http\Controllers;

use App\Services\CompanyService;
use App\Services\InvoiceService;
use App\Services\RecipientService;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;

class InvoiceController extends Controller
{
    private CompanyService $companyService;
    private UserService $userService;
    private InvoiceService $invoiceService;
    private RecipientService $recipientService;

    public function __construct(CompanyService $companyService, UserService $userService,
                                InvoiceService $invoiceService, RecipientService $recipientService)
    {
        $this->companyService = $companyService;
        $this->userService = $userService;
        $this->invoiceService = $invoiceService;
        $this->recipientService = $recipientService;
    }

    public function index(): Factory|View|Application|RedirectResponse
    {
        $result = $this->companyService->findByUserId($this->userService->getUserIdWeb());
        $companies = $result['companies']->toArray();
        $invoice = [];
        $invoices = [];

        if (request()->has('invoice')) {
            $invoice = $this->invoiceService->show(request()->query('invoice'))['invoice'];
        }

        if (!request()->has('company')) {
            if (isset($this)) {
                $invoices = $this->invoiceService->findByCompanyId($companies[0]['id'])['invoices'];
            }
            return redirect()->route('invoices', ['company' => $companies[0]['id']])->
            with(['companies' => $companies, 'invoices' => $invoices, 'invoice' => $invoice]);
        } else {
            if (!empty($this->invoiceService->findByCompanyId(request()->query('company'))['invoices'])) {
                $invoices = $this->invoiceService->findByCompanyId(request()->query('company'))['invoices'];
            }
            return view('invoices', ['companies' => $companies, 'invoices' => $invoices, 'invoice' => $invoice]);
        }
    }

    public function createView(): Factory|View|Application
    {
        $issuer = [];
        $recipients = [];
        if (request()->has('company')) {
            if (!empty($this->companyService->show(request()->query('company'))['company'])) {
                $issuer = $this->companyService->show(request()->query('company'))['company'];
            }
            /*if (!empty($this->recipientService)) {
                $recipients = $this->recipientService->getByCompanyId(request()->query('company'))['recipients'];
            }*/
        }

        return view('create_invoice', ['issuer' => $issuer, 'recipients' => $recipients]);
    }
}
