<?php

namespace App\Services;

use App\Constants;
use App\Models\BankAccount;
use App\Models\Company;
use App\Models\Recipient;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RecipientService
{
    private BankAccountService $bankAccountService;

    public function __construct(BankAccountService $bankAccountService)
    {
        $this->bankAccountService = $bankAccountService;
    }

    public function show($id): array
    {
        $recipient = Recipient::with('bankAccounts')->find($id);

        if (!$recipient) {
            return ['success' => false, 'message' => Constants::RECIPIENT_NOT_FOUND . ' with ID: ' . $id];
        }

        return ['success' => true, 'message' => 'OK', 'recipient' => $recipient->toArray()];
    }

    public function store(array $data, string $company_id): array
    {
        $data['company_id'] = $company_id;

        try {
            $validated_data = Validator::make($data, Recipient::$rules)->validate();

            DB::beginTransaction();

            try {
                if (count($data['bank_accounts']) > 0) {
                    $recipient = Recipient::create($validated_data);

                    foreach ($data['bank_accounts'] as $bank_account) {
                        $this->bankAccountService->store($bank_account, $recipient->id, true);
                    }

                    DB::commit();

                    $recipient['bank_accounts'] = $data['bank_accounts'];

                    return ['success' => true, 'message' => Constants::RECIPIENT_SAVE_SUCCESS,
                        'recipient' => $recipient];
                } else {
                    DB::rollBack();
                    return ['success' => false, 'message' => 'Recipient must have at least one bank account'];
                }
            } catch (Exception $e) {
                DB::rollBack();
                return ['success' => false, 'message' => 'Failed to save recipient: ' . $e->getMessage()];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => Constants::RECIPIENT_SAVE_FAIL . ':' . $e->getMessage()];
        }
    }

    public function getByCompanyId($id): array
    {
        $company = (new Company)->find($id);

        if (!$company) {
            return ['success' => false, 'message' => Constants::COMPANY_NOT_FOUND . ' with ID: ' . $id];
        } else {
            $recipients = $company->recipients;
        }

        if (!$recipients) {
            return ['success' => false, 'message' => Constants::RECIPIENT_NOT_FOUND . ' with ID: ' . $id];
        }

        foreach ($recipients as $recipient) {
            $recipient->load('bankAccounts');
        }

        return ['success' => true, 'recipients' => $recipients];
    }

    public function update(array $data, string $id): array
    {
        $recipient = Recipient::find($id);

        $data['company_id'] = $recipient->company_id;

        try {
            $validated_data = Validator::make($data, Recipient::$rules)->validate();
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }

        if (!$recipient) {
            return ['success' => false, 'message' => Constants::RECIPIENT_NOT_FOUND . ' with ID: ' . $id];
        }

        try {
            $recipient->update($validated_data);
            return ['success' => true, 'message' => Constants::RECIPIENT_UPDATE_SUCCESS,
                'recipient' => $recipient];
        } catch (Exception $e) {
            return ['success' => false, 'message' => Constants::RECIPIENT_UPDATE_FAIL . ' ' . $e->getMessage()];
        }
    }

    public function destroy($id): array
    {
        $recipient = Recipient::find($id);

        if (!$recipient) {
            return ['success' => false, 'message' => Constants::RECIPIENT_NOT_FOUND . ' with ID: ' . $id];
        }

        try {
            BankAccount::where('recipient_id', $id)->delete();
            $recipient->delete();
            return ['success' => true, 'message' => Constants::RECIPIENT_DELETE_SUCCESS, 'recipient' => $recipient];
        } catch (Exception $e) {
            return ['success' => false, 'message' => Constants::RECIPIENT_DELETE_FAIL . ' ' . $e->getMessage(),
                'recipient' => $recipient];
        }
    }
}
