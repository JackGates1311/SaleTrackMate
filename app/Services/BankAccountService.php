<?php

namespace App\Services;

use App\Constants;
use App\Models\BankAccount;
use App\Models\Company;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BankAccountService
{
    /**
     * @throws ValidationException
     */
    public function store(array $data, string $company_id): array
    {
        $data['company_id'] = $company_id;

        $validated_data = Validator::make($data, BankAccount::$rules)->validate();

        try {
            $bank_account = BankAccount::create($validated_data);

            return ['success' => true, 'message' => Constants::BANK_ACCOUNT_SAVE_SUCCESS,
                'bank_account' => $bank_account];
        } catch (Exception $e) {
            return ['success' => false,
                'message' => Constants::BANK_ACCOUNT_SAVE_FAIL . ' ' . $e->getMessage()];
        }
    }

    public function findByCompanyId($id): array
    {
        $company = (new Company)->find($id);

        if (!$company) {
            return ['success' => false, 'message' => Constants::COMPANY_NOT_FOUND . ' with ID: ' . $id];
        } else {
            $bank_accounts = $company->bankAccounts;
        }

        if (!$bank_accounts) {
            return ['success' => false, 'message' => Constants::BANK_ACCOUNT_NOT_FOUND . ' ' . $id];
        }

        return ['success' => true, 'bank_accounts' => $bank_accounts];
    }

    /**
     * @throws ValidationException
     */
    public function update(array $data, $id): array
    {
        $validated_data = Validator::make($data, BankAccount::$rules)->validate();

        $bank_account = BankAccount::find($id);

        if (!$bank_account) {
            return ['success' => false, 'message' => Constants::BANK_ACCOUNT_NOT_FOUND . ' ' . $id];
        }

        try {
            $bank_account->update($validated_data);
            return ['success' => true, 'message' => Constants::BANK_ACCOUNT_UPDATE_SUCCESS,
                'bank_account' => $bank_account];
        } catch (Exception $e) {
            return ['success' => false, 'message' => Constants::BANK_ACCOUNT_UPDATE_FAIL . $e->getMessage()];
        }
    }
}
