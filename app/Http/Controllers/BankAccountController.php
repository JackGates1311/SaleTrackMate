<?php

namespace App\Http\Controllers;

use App\Services\BankAccountService;
use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;

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
        session(['edit_bank_account' => false]);

        return view('account', ['companies' => [], 'bank_accounts' =>
            $this->bankAccountService->findByCompanyId(request()->query('company'))['bank_accounts']]);
    }

    public function edit(): Factory|View|Application
    {
        session(['company_edit' => false]);
        session(['company_create' => false]);
        session(['manage_bank_accounts' => false]);
        session(['edit_bank_account' => true]);

        $bank_account = $this->bankAccountService->show(request()->query('bank_account'))['bank_account']->toArray();

        $bank_accounts[0] = $bank_account;

        return view('account', ['companies' => [], 'bank_accounts' => $bank_accounts]);
    }

    public function delete(): RedirectResponse
    {
        $result = $this->bankAccountService->destroy(request()->query('bank_account'));

        if ($result['success']) {
            return redirect()->route('bank_accounts', ['company' => $result['bank_account']['company_id']])->
            with(['message' => $result['message']]);
        } else {
            return redirect()->route('bank_accounts', ['company' => $result['bank_account']['company_id']])->
            withErrors(['message' => $result['message']]);
        }
    }

    /**
     * @throws ValidationException
     */
    public function update(Request $request): RedirectResponse
    {
        $result = $this->bankAccountService->update($request->except('_token')['bank_accounts'][0],
            $request->query('bank_account'));

        if ($result['success']) {
            return redirect()->route('bank_accounts', ['company' => $result['bank_account']['company_id']])->with(
                ['message' => $result['message']]);
        } else {
            return redirect()->route('bank_accounts', ['company' => $result['bank_account']['company_id']])->withErrors(
                ['message' => $result['message']]);
        }
    }

    /**
     * @throws ValidationException
     */
    public function create(Request $request): RedirectResponse
    {
        $result = $this->bankAccountService->store($request->except('_token')['bank_accounts'][0],
            $request->query('company'));

        if ($result['success']) {
            return redirect()->route('bank_accounts', ['company' => $result['bank_account']['company_id']])->with(
                ['message' => $result['message']]);
        } else {
            return redirect()->route('bank_accounts', ['company' => $result['bank_account']['company_id']])->withErrors(
                ['message' => $result['message']]);
        }
    }
}
