<?php

namespace App\Services;

use App\Constants;
use App\Models\Company;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyService
{
    private BankAccountService $bankAccountService;
    private FiscalYearService $fiscalYearService;

    public function __construct(BankAccountService $bankAccountService, FiscalYearService $fiscalYearService)
    {
        $this->bankAccountService = $bankAccountService;
        $this->fiscalYearService = $fiscalYearService;
    }

    public function index(): array
    {
        return ['companies' => Company::with('bankAccounts', 'fiscalYears')->get()->toArray()];
    }

    public function show($id): array
    {
        $company = Company::with('bankAccounts', 'fiscalYears')->find($id);

        if (!$company) {
            return ['success' => false, 'message' => Constants::COMPANY_NOT_FOUND . ' ' . $id];
        }

        return ['success' => true, 'message' => 'OK', 'company' => $company->toArray()];
    }

    public function store(Request $request, string $user_id): array
    {
        $request['user_id'] = $user_id;

        $validated_data = $request->validate(Company::$rules);

        try {

            DB::beginTransaction();

            try {

                $company = Company::create($validated_data);

                foreach ($request->toArray()['bank_accounts'] as $bank_account) {
                    $this->bankAccountService->store($bank_account, $company->id);
                }

                $fiscal_year = $this->fiscalYearService->store(date('Y'), $company->id);

                DB::commit();

                $company['bank_accounts'] = $request->toArray()['bank_accounts'];
                $company['fiscal_years'] = $fiscal_year['fiscal_year'];

                return ['success' => true, 'message' => Constants::COMPANY_SAVE_SUCCESS, 'company' => $company];

            } catch (Exception $e) {
                DB::rollBack();
                return ['success' => false, 'message' => 'Failed to save company: ' . $e->getMessage()];
            }

        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Failed to save company: ' . $e->getMessage()];
        }
    }

    public function update(Request $request, $id): array
    {
        $validated_data = $request->validate(Company::$rules);

        $company = Company::find($id);

        if (!$company) {
            return ['success' => false, 'message' => Constants::COMPANY_NOT_FOUND];
        }

        try {
            $company->update($validated_data);
            return ['success' => true, 'message' => Constants::COMPANY_UPDATE_SUCCESS, 'company' => $company];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Failed to update company: ' . $e->getMessage()];
        }
    }

    public function findByUserId($id): array
    {
        $user = (new User)->find($id);

        if (!$user) {
            return ['success' => false, 'message' => Constants::USER_NOT_FOUND . ' with ID: ' . $id];
        } else {
            $companies = $user->companies;
        }

        if (!$companies) {
            return ['success' => false, 'message' => Constants::COMPANY_NOT_FOUND . ' with ID: ' . $id];
        }

        foreach ($companies as $company) {
            $company->load('bankAccounts');
            $company->load('fiscalYears');
        }

        return ['success' => true, 'companies' => $companies];
    }
}
