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

        $this->selected_company = $this->companyService->findSelectedCompany(request()->query('company'));

        $user_companies = $this->userService->getUserCompanies();

        if (!$user_companies) {
            session(['company_create' => true]);
            return view('account', ['companies' => [],
                'selected_company' => []]);
        } else {
            return view('account', ['companies' => $user_companies,
                'selected_company' => $this->selected_company]);
        }
    }

    public function edit(): Factory|View|Application
    {
        session(['company_edit' => true]);
        session(['company_create' => false]);
        session(['manage_bank_accounts' => false]);
        session(['edit_bank_account' => false]);

        $this->selected_company = $this->companyService->findSelectedCompany(request()->query('company'));

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
            return back()
                ->withErrors(['message' => $result['message']])
                ->withInput();
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

    public function create(Request $request): Factory|View|RedirectResponse|Application
    {
        $result = $this->companyService->store($request->except('_token'), $this->userService->getUserIdWeb());

        if ($result['success']) {
            return redirect()->route('companies', ['company' => $result['company']['id']])->with(
                ['message' => $result['message']]);
        } else {
            return back()
                ->withErrors(['message' => $result['message']])
                ->withInput();
        }
    }

    public function selectCompany(Request $request): RedirectResponse
    {
        $selected_company_id = $request->input('company');

        $entity = $request->input('entity');

        $companies = $this->companyService->findByUserId($this->userService->getUserIdWeb())['companies'];

        foreach ($companies as $company) {
            if ($company['id'] === $selected_company_id) {
                $this->selected_company = $company;
                break;
            }
        }

        if ($entity == 'companies') {
            return redirect()->route('companies', ['company' => $selected_company_id])->
            with(['companies' => $companies, 'selected_company' => $this->selected_company]);
        } else if ($entity == 'recipients') {
            return redirect()->route('recipients', ['company' => $selected_company_id])->
            with(['companies' => $companies, 'selected_company' => $this->selected_company]);
        } else if ($entity == 'analytics') {
            return redirect()->route('invoice_analytics', ['company' => $selected_company_id,
                'period' => $request['period'] ?? 'daily'])->
            with(['companies' => $companies, 'selected_company' => $this->selected_company]);
        } else {
            return redirect()->route('goods_and_services', ['company' => $selected_company_id])->
            with(['companies' => $companies, 'selected_company' => $this->selected_company]);
        }
    }
}
