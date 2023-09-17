<?php

namespace App\Http\Controllers;

use App\Services\CompanyService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;

class CompanyController extends Controller
{
    private UserService $userService;
    private CompanyService $companyService;

    public function __construct(UserService $userService, CompanyService $companyService)
    {
        $this->userService = $userService;
        $this->companyService = $companyService;
    }

    public function index(): Factory|View|Application
    {
        session(['company_edit' => false]);
        session(['company_create' => false]);
        session(['manage_bank_accounts' => false]);
        session(['edit_bank_account' => false]);
        return view('account', ['companies' => $this->userService->getUserCompanies()]);
    }

    public function edit(): Factory|View|Application
    {
        session(['company_edit' => true]);
        session(['company_create' => false]);
        session(['manage_bank_accounts' => false]);
        session(['edit_bank_account' => false]);
        return view('account', ['companies' => $this->userService->getUserCompanies()]);
    }

    /**
     * @throws ValidationException
     */
    public function update(Request $request): RedirectResponse
    {
        $result = $this->companyService->update($request->except('_token'), $request->query('company'),
            $this->userService->getUserIdWeb());

        if ($result['success']) {
            return redirect()->route('companies', ['company' => $result['company']['id']])->with(
                ['message' => $result['message']]);
        } else {
            return redirect()->route('companies', ['company' => $result['company']['id']])->
            withErrors(['message' => $result['message']]);
        }
    }

    public function createView(): Factory|View|Application
    {
        session(['company_edit' => false]);
        session(['company_create' => true]);
        session(['manage_bank_accounts' => false]);
        session(['edit_bank_account' => false]);
        return view('account', ['companies' => []]);
    }

    /**
     * @throws ValidationException
     */
    public function create(Request $request): RedirectResponse
    {
        $result = $this->companyService->store($request->except('_token'), $this->userService->getUserIdWeb());

        if ($result['success']) {
            return redirect()->route('companies', ['company' => $result['company']['id']])->with(
                ['message' => $result['message']]);
        } else {
            return redirect()->route('companies', ['company' => $result['company']['id']])->
            withErrors(['message' => $result['message']]);
        }
    }
}
