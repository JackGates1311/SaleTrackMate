<?php

namespace App\Services;

use App\Constants;
use App\Models\Company;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class CompanyService
{
    public function index(): array
    {
        return ['companies' => Company::all()->toArray()];
    }

    public function show($id): array
    {
        $company = Company::find($id);

        if (!$company) {
            return ['success' => false, 'message' => Constants::COMPANY_NOT_FOUND . ' ' . $id];
        }

        return ['success' => true, 'message' => 'OK', 'company' => $company->toArray()];
    }

    public function store(Request $request): array
    {
        $validated_data = $request->validate(Company::$rules);

        try {
            $company = Company::create($validated_data);
            return ['success' => true, 'message' => Constants::COMPANY_SAVE_SUCCESS, 'company' => $company];
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

        return ['success' => true, 'companies' => $companies];
    }
}
