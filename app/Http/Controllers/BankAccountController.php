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

        if (request()->has('recipient')) {
            return view('manage_recipient_bank_accounts', ['bank_accounts' =>
                $this->bankAccountService->findByRecipientId(request()->query('recipient'))['bank_accounts']]);
        } else {
            return view('account', ['companies' => [], 'bank_accounts' =>
                $this->bankAccountService->findByCompanyId(request()->query('company'))['bank_accounts']]);
        }
    }

    public function edit(): Factory|View|Application
    {
        session(['company_edit' => false]);
        session(['company_create' => false]);
        session(['manage_bank_accounts' => false]);
        session(['edit_bank_account' => true]);

        $bank_account = $this->bankAccountService->show(request()->query('bank_account'))['bank_account']->toArray();

        $bank_accounts[0] = $bank_account;

        if (isset($bank_account['recipient_id'])) {
            return view('manage_recipient_bank_accounts', ['companies' => [], 'bank_accounts' => $bank_accounts]);
        } else {
            return view('account', ['companies' => [], 'bank_accounts' => $bank_accounts]);
        }
    }

    public function delete(): RedirectResponse
    {
        $result = $this->bankAccountService->destroy(request()->query('bank_account'));

        return $this->loadManageBankAccountsPage($result);
    }

    /**
     * @throws ValidationException
     */
    public function update(Request $request): RedirectResponse
    {
        $result = $this->bankAccountService->update($request->except('_token')['bank_accounts'][0],
            $request->query('bank_account'));

        return $this->loadManageBankAccountsPage($result);
    }

    /**
     * @throws ValidationException
     */
    public function create(Request $request): RedirectResponse
    {
        $isRecipient = false;

        if (request()->has('recipient')) {
            $isRecipient = true;
            $result = $this->bankAccountService->store($request->except('_token')['bank_accounts'][0],
                $request->query('recipient'), true);
        } else {
            $result = $this->bankAccountService->store($request->except('_token')['bank_accounts'][0],
                $request->query('company'), false);
        }

        if ($result['success']) {
            if ($isRecipient) {
                return redirect()->route('bank_accounts',
                    ['company' => $request->query('company'),
                        'recipient' => $result['bank_account']['recipient_id']])->with(
                    ['message' => $result['message']]);
            } else {
                return redirect()->route('bank_accounts',
                    ['company' => $result['bank_account']['company_id']])->with(['message' => $result['message']]);
            }

        } else {
            if ($isRecipient) {
                return redirect()->route('bank_accounts',
                    ['company' => $request->query('company'),
                        'recipient' => $result['bank_account']['recipient_id']])->withErrors(
                    ['message' => $result['message']]);
            } else {
                return redirect()->route('bank_accounts',
                    ['company' => $result['bank_account']['company_id']])->withErrors(
                    ['message' => $result['message']]);
            }
        }
    }

    /**
     * @param array $result
     * @return RedirectResponse
     */
    public function loadManageBankAccountsPage(array $result): RedirectResponse
    {
        if ($result['success']) {
            if (isset($result['bank_account']['recipient_id'])) {
                return redirect()->route('bank_accounts', ['company' => request()->query('company'),
                    'recipient' => $result['bank_account']['recipient_id']])->with(['message' => $result['message']]);
            } else {
                return redirect()->route('bank_accounts', ['company' => $result['bank_account']['company_id']])->
                with(['message' => $result['message']]);
            }
        } else {
            if (isset($result['bank_account']['recipient_id'])) {
                return redirect()->route('bank_accounts', ['company' => request()->query('company'),
                    'recipient' => $result['bank_account']['recipient_id']])->withErrors([
                    'message' => $result['message']]);
            } else {
                return redirect()->route('bank_accounts', ['company' => $result['bank_account']['company_id']])->
                withErrors(['message' => $result['message']]);
            }

        }
    }
}
