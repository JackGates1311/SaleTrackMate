<?php

namespace App\Http\Controllers;

use App\Models\Company;
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
    private ?Company $selected_company;
    private UserService $userService;
    private CompanyService $companyService;

    public function __construct(UserService $userService, CompanyService $companyService)
    {
        $this->userService = $userService;
        $this->companyService = $companyService;
        $this->selected_company = null;
    }

    public function index(): Factory|View|Application
    {
        session(['company_edit' => false]);
        session(['company_create' => false]);
        session(['manage_bank_accounts' => false]);
        session(['edit_bank_account' => false]);

        $this->selected_company = Company::with('bankAccounts',
            'fiscalYears')->find(request()->query('company'));

        return view('account', ['companies' => $this->userService->getUserCompanies(),
            'selected_company' => $this->selected_company]);
    }

    public function edit(): Factory|View|Application
    {
        session(['company_edit' => true]);
        session(['company_create' => false]);
        session(['manage_bank_accounts' => false]);
        session(['edit_bank_account' => false]);

        $this->selected_company = Company::with('bankAccounts',
            'fiscalYears')->find(request()->query('company'));

        return view('account', ['companies' => $this->userService->getUserCompanies(),
            'selected_company' => $this->selected_company]);
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
                ['selected_company' => $this->selected_company, 'message' => $result['message']]);
        } else {
            return redirect()->route('companies', ['company' => $result['company']['id'],
                'selected_company' => $this->selected_company])->withErrors(['message' => $result['message']]);
        }
    }

    public function createView(): Factory|View|Application
    {
        session(['company_edit' => false]);
        session(['company_create' => true]);
        session(['manage_bank_accounts' => false]);
        session(['edit_bank_account' => false]);
        return view('account', ['companies' => [], 'selected_company' => []]);
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

    public function selectCompany(Request $request): RedirectResponse
    {
        $selected_company_id = $request->input('company');

        $companies = $this->companyService->findByUserId($this->userService->getUserIdWeb())['companies'];

        foreach ($companies as $company) {
            if ($company['id'] === $selected_company_id) {
                $this->selected_company = $company;
                break;
            }
        }

        return redirect()->route('companies', ['company' => $selected_company_id])->
        with(['companies' => $companies, 'selected_company' => $this->selected_company]);
    }
}
