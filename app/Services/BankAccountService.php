<?php

namespace App\Services;

use App\Constants;
use App\Models\BankAccount;
use App\Models\Company;
use App\Models\Recipient;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BankAccountService
{
    /**
     * @throws ValidationException
     */
    public function store(array $data, string $id, bool $isRecipient): array
    {
        if ($isRecipient) {
            $data['recipient_id'] = $id;
        } else {
            $data['company_id'] = $id;
        }

        $validated_data = Validator::make($data, BankAccount::$rules)->validate();

        try {
            $bank_account = BankAccount::create($validated_data);

            return ['success' => true, 'message' => Constants::BANK_ACCOUNT_SAVE_SUCCESS,
                'bank_account' => $bank_account];
        } catch (Exception $e) {
            return ['success' => false,
                'message' => Constants::BANK_ACCOUNT_SAVE_FAIL . ': ' . $e->getMessage()];
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

    public function findByRecipientId($id): array
    {
        $recipient = (new Recipient)->find($id);

        if (!$recipient) {
            return ['success' => false, 'message' => Constants::RECIPIENT_NOT_FOUND . ' with ID: ' . $id];
        } else {
            $bank_accounts = $recipient->bankAccounts;
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
        $bank_account = BankAccount::find($id);

        if (!$bank_account) {
            return ['success' => false, 'message' => Constants::BANK_ACCOUNT_NOT_FOUND . ' ' . $id];
        }

        if (isset($bank_account->toArray()['recipient_id'])) {
            $data['recipient_id'] = $bank_account['recipient_id'];
        } else {
            $data['company_id'] = $bank_account['company_id'];
        }

        $validated_data = Validator::make($data, BankAccount::$rules)->validate();

        try {
            $bank_account->update($validated_data);
            return ['success' => true, 'message' => Constants::BANK_ACCOUNT_UPDATE_SUCCESS,
                'bank_account' => $bank_account];
        } catch (Exception $e) {
            return ['success' => false, 'message' => Constants::BANK_ACCOUNT_UPDATE_FAIL . $e->getMessage()];
        }
    }

    public function destroy($id): array
    {
        $bank_account = BankAccount::find($id);

        if (!$bank_account) {
            return ['success' => false, 'message' => Constants::BANK_ACCOUNT_NOT_FOUND . $id,
                'bank_account' => $bank_account];
        }

        if (isset($bank_account->toArray()['recipient_id'])) {
            $count = BankAccount::where('recipient_id', $bank_account['recipient_id'])->count();
        } else {
            $count = BankAccount::where('company_id', $bank_account['company_id'])->count();
        }

        if ($count <= 1) {
            return ['success' => false, 'message' => "You cannot delete this bank account",
                'bank_account' => $bank_account];
        } else {
            $bank_account->delete();
            return ['success' => true, 'message' => Constants::BANK_ACCOUNT_DELETE_SUCCESS,
                'bank_account' => $bank_account];
        }
    }

    public function show($id): array
    {
        $bank_account = BankAccount::find($id);

        if (!$bank_account) {
            return ['success' => false, 'message' => Constants::BANK_ACCOUNT_NOT_FOUND . $id];
        }

        return ['success' => true, 'bank_account' => $bank_account];
    }
}
