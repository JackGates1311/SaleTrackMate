<?php

namespace App\Services;

use App\Constants;
use App\Models\BankAccount;
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
}
