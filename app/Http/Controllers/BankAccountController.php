<?php

namespace App\Http\Controllers;

use App\Services\BankAccountService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

class BankAccountController extends Controller
{
    private BankAccountService $bankAccountService;

    public function __construct(BankAccountService $bankAccountService)
    {
        $this->bankAccountService = $bankAccountService;
    }

    public function index(): Factory|View|Application
    {
        session(['company_edit' => false]);
        session(['company_create' => false]);
        session(['manage_bank_accounts' => true]);

        return view('account', ['companies' => [], 'bank_accounts' =>
            $this->bankAccountService->findByCompanyId(request()->query('company'))['bank_accounts']]);
    }

    public function edit()
    {

    }
}
